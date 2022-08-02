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
        if ($insert->has('dailyactivitypics')) {
            $comptpic = find_type()->in([DBTypes::dailyactivitypics])->get(DBTypes::dailyactivitypics)->getId();
            foreach ($insert->get('dailyactivitypics') as  $file) {
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

        if ($insert->has('dailyactivitypics')) {
            $comptpic = find_type()->in([DBTypes::dailyactivitypics])->get(DBTypes::dailyactivitypics)->getId();

            $files = new FileFinder($comptpic, $competitor->comptid);
            $ids = collect($files->all())->map(function (FileColumn $item) {
                return $item->getId();
            });

            $files = Files::whereIn('fileid', $ids->toArray())->get();
            foreach ($files as $file) {
                $file->delete();
            }

            foreach ($insert->get('dailyactivitypics') as  $file) {
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

    public function getAll(Collection $whereArr)
    {
        $query = $this->getQuery();

        $competitorWhere = $whereArr->only($this->fillable);
        if ($competitorWhere->isNotEmpty()) {
            $query->where($competitorWhere->toArray());
        }

        return $query->get();
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'dailyactivitycat' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'dailyactivitytype' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'dailyactivitypics' => function ($query) {
                $query->addSelect(DB::raw("*,concat('" . url('storage') . "', '/', \"directories\", '',\"filename\") as url"))
                    ->whereHas('transtype', function ($query) {
                        $query->where('typecd', DBTypes::dailyactivitypics);
                    });
            },
        ]);
    }
}
