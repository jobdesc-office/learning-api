<?php

namespace App\Services\Masters;

use App\Collections\Files\FileColumn;
use App\Collections\Files\FileFinder;
use App\Collections\Files\FileUploader;
use App\Models\Masters\ActivityCF;
use App\Models\Masters\DailyActivity;
use App\Models\Masters\Files;
use Carbon\Carbon;
use DBTypes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DailyActivityServices extends DailyActivity
{

    public function details($id)
    {
        return $this->getQuery()
            ->where('dayactrefid', $id)
            ->where('dayactreftypeid', find_type()->in([\DBTypes::dayactreftypeprospect])->get(\DBTypes::dayactreftypeprospect)->getId())->orderBy('dayactdate', 'desc');
    }

    public function select($searchValue, $bpid)
    {
        return $this->getQuery()->select('*')
            ->whereHas('dayactuser', function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(userfullname))'), 'like', "%$searchValue%");
            })

            ->whereHas('dayactuser', function ($query) use ($bpid) {
                $query->with([
                    'userdetails' => function ($query) use ($bpid) {
                        $query->where('userdtbpid', $bpid);
                    }
                ]);
            })
            ->orderBy('dayactdate', 'asc')
            ->get();
    }

    public function find($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function store(Collection $insert)
    {
        $this->fill($insert->toArray())->save();
        if ($insert->has('dayactpics')) {
            $comptpic = find_type()->in([DBTypes::dailyactivitypics])->get(DBTypes::dailyactivitypics)->getId();
            foreach ($insert->get('dayactpics') as  $file) {
                $temp_path = $file->getPathname();
                $filename = Str::replace(['/', '\\'], '', Hash::make(Str::random())) . '.' . $file->getClientOriginalExtension();

                $file = new FileUploader($temp_path, $filename, 'images/', $comptpic, $this->comptid);
                $file->upload();
            }
        }
    }

    public function edit($id, Collection $insert)
    {
        $competitor = $this->find($id)->fill($insert->toArray());
        $competitor->save();

        if ($insert->has('dayactpics')) {
            $comptpic = find_type()->in([DBTypes::dailyactivitypics])->get(DBTypes::dailyactivitypics)->getId();

            $files = new FileFinder($comptpic, $competitor->comptid);
            $ids = collect($files->all())->map(function (FileColumn $item) {
                return $item->getId();
            });

            $files = Files::whereIn('fileid', $ids->toArray())->get();
            foreach ($files as $file) {
                $file->delete();
            }

            foreach ($insert->get('dayactpics') as  $file) {
                $temp_path = $file->getPathname();
                $filename = Str::replace(['/', '\\'], '', Hash::make(Str::random()));

                $file = new FileUploader($temp_path, $filename, 'images/', $comptpic, $competitor->comptid);
                $file->upload();
            }
        }
    }

    public function datatables($id, $startDate, $endDate, $categoryid)
    {
        $query = $this->getQuery()
            ->select('vtdailyactivity.*')
            ->join('msuser', 'vtdailyactivity.createdby', '=', 'msuser.userid')
            ->join('msuserdt', 'msuser.userid', '=', 'msuserdt.userid')
            ->orderBy('vtdailyactivity.dayactdate', 'asc')
            ->where('msuserdt.userdtbpid', $id);

        if ($categoryid != null) {
            $query =  $query->where('vtdailyactivity.dayactcatid', $categoryid);
        }
        if ($startDate != null && $endDate != null) {
            $query =  $query->whereBetween('vtdailyactivity.dayactdate', [$startDate, $endDate]);
        }
        if ($startDate != null && $endDate == null) {
            $query =  $query->where('vtdailyactivity.dayactdate', $startDate);
        }

        return $query;
    }

    public function getBp(int $id)
    {
        return $this->getQuery()
            ->select('vtdailyactivity.*')
            ->join('msuser', 'vtdailyactivity.createdby', '=', 'msuser.userid')
            ->join('msuserdt', 'msuser.userid', '=', 'msuserdt.userid')
            ->where('msuserdt.userdtbpid', $id)->get();
    }

    public function addAll(Collection $activities)
    {
        $activityService = new DailyActivityServices;
        $activities->put('activities', json_decode($activities->get('activities')));
        $data = array_map(function ($item) use ($activityService) {
            $item = collect($item);
            $item->put('createdby', auth()->user()->userid);
            $item->put('dayactcd', $activityService->generateCode());
            $activity = new DailyActivity;
            $activity->fill($item->filter()->all())->save();
            return collect($activity->attributes)->put('file', $item->get('file'))->put('customfields', $item->get('customfields'))->all();
        }, $activities->get('activities'));

        foreach ($data as $value) {
            $activity = collect($value);
            if ($activities->has($activity->get('file'))) {
                $dayactpics = find_type()->in([DBTypes::dailyactivitypics])->get(DBTypes::dailyactivitypics)->getId();
                foreach ($activities->get($activity->get('file')) as  $file) {
                    $temp_path = $file->getPathname();
                    $filename = Str::replace(['/', '\\'], '', Hash::make(Str::random())) . '.' . $file->getClientOriginalExtension();

                    $file = new FileUploader($temp_path, $filename, 'images/', $dayactpics, $activity->get('dayactid'));
                    $file->upload();
                }
            }

            if ($activity->has('customfields')) {
                foreach ($activity->get('customfields') as $customfield) {
                    $activitycf = new ActivityCF;
                    $activitycf->fill(collect($customfield)->all());
                    $activitycf->activityid =  $activity->get('dayactid');
                    $activitycf->save();
                }
            }
        }
    }

    public function getAll(Collection $whereArr)
    {
        try {
            $userids = null;

            if (!$whereArr->has('userchildid')) {
                $users = kacungs($whereArr->get('groupid'));
                $userids = $users->map(function ($item) {
                    return $item->userid;
                })->toArray();
            }

            $query = $this->getQuery();

            $dailyactivityWhere = $whereArr->only($this->fillable);
            if ($dailyactivityWhere->isNotEmpty()) {
                $query = $query->where($dailyactivityWhere->toArray());
                if ($userids) {
                    $query = $query->orWhereIn('createdby', $userids);
                }
            }

            if ($whereArr->has('startdate')) {
                $query = $query->whereDate('dayactdate', ">=", $whereArr->get('startdate'));
            }

            if ($whereArr->has('enddate')) {
                $query = $query->whereDate('dayactdate', "<=", $whereArr->get('enddate'));
            }

            if ($whereArr->has('bpid')) {
                $bpid = $whereArr->get('bpid');
                $query = $query->whereHas('dayactuser', function ($query) use ($bpid) {
                    $query = $query->whereHas('userdetails', function ($query) use ($bpid) {
                        $query->where('userdtbpid', $bpid);
                    });
                });
            }

            if ($whereArr->has("search")) {
                $query = $query->where(DB::raw('TRIM(LOWER(dayactdesc))'), 'like', "%" . Str::lower($whereArr->get('search')) . "%");
            }

            return $query->get();
        } catch (\Throwable $e) {
            dd($e);
        }
    }

    public function countAll(Collection $whereArr)
    {
        $query = $this->getQuery();
        $users = kacungs();
        $userids = $users->map(function ($item) {
            return $item->userid;
        })->toArray();

        $dailyactivityWhere = $whereArr->only($this->fillable);
        if ($dailyactivityWhere->isNotEmpty()) {
            $query = $query->where($dailyactivityWhere->toArray());
            if ($userids) {
                $query = $query->orWhereIn('createdby', $userids);
            }
        }

        return $query->count();
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'dayactuser',
            'schedules',
            'dayactreftype',
            'refprospect' => function ($query) {
                $query->with(['prospectcust', 'prospectstatus', 'prospectowneruser' => function ($query) {
                    $query->with(['user']);
                }]);
            },
            'dayactupdatedby',
            'dayactcust',
            'dayactcat' => function ($query) {
                $query->select('sbtid', 'sbttypename');
            },
            'dayactcust',
            "activitycustomfield" => function ($query) {
                $query->with(['customfield']);
            },
            'dayactpics' => function ($query) {
                $query->addSelect(DB::raw("*,concat('" . url('storage') . "', '/', \"directories\", '',\"filename\") as url"))
                    ->whereHas('transtype', function ($query) {
                        $query->where('typecd', DBTypes::dailyactivitypics);
                    });
            },
        ])->orderBy('createddate', 'desc');
    }

    function generateCode()
    {
        $code = "ACT";

        $date = Carbon::now();
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $count = DailyActivity::count() + 1;
        $increment = str_pad($count, 4, "0", STR_PAD_LEFT);

        return "$code$year$month$day$increment";
    }
}
