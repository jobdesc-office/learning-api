<?php

namespace App\Services\Masters;

use App\Collections\Files\FileColumn;
use App\Collections\Files\FileFinder;
use App\Collections\Files\FileUploader;
use App\Models\Masters\DailyActivity;
use App\Models\Masters\Files;
use DBTypes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DailyActivityServices extends DailyActivity
{
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

    public function getBp(int $id)
    {
        return $this->getQuery()
            ->join('msuserdt', 'vtdailyactivity.createdby', '=', 'msuserdt.userid')
            ->join('msuser', 'msuser.userid', '=', 'msuserdt.userid')
            ->where('msuserdt.userdtbpid', $id)->get();
    }

    public function addAll(Collection $activities)
    {
        $activities->put('activities', json_decode($activities->get('activities')));
        $data = array_map(function ($item) {
            $item = collect($item);
            $item->put('createdby', auth()->user()->userid);
            $activity = new DailyActivity;
            $activity->fill($item->filter()->all())->save();
            return collect($activity->attributes)->put('file', $item->get('file'))->all();
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
        }
    }

    public function getAll(Collection $whereArr)
    {
        $query = $this->getQuery();

        $dailyactivityWhere = $whereArr->only($this->fillable);
        if ($dailyactivityWhere->isNotEmpty()) {
            $query = $query->where($dailyactivityWhere->toArray());
        }

        if ($whereArr->has("search")) {
            $query = $query->where(DB::raw('TRIM(LOWER(dayactdesc))'), 'like', "%" . Str::lower($whereArr->get('search')) . "%");
        }

        return $query->get();
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'dayactcust',
            'dayactcat' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'dayactcust',
            'dayacttype' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'dayactpics' => function ($query) {
                $query->addSelect(DB::raw("*,concat('" . url('storage') . "', '/', \"directories\", '',\"filename\") as url"))
                    ->whereHas('transtype', function ($query) {
                        $query->where('typecd', DBTypes::dailyactivitypics);
                    });
            },
        ]);
    }
}
