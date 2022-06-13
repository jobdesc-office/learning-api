<?php

namespace App\Services\Masters;

use App\Models\Masters\Subdistrict;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SubdistrictServices extends Subdistrict
{
    public function datatables($order, $orderby)
    {
        return $this->getQuery()

            ->orderBy($order, $orderby);
    }

    public function find($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function getAll(Collection $whereArr)
    {
        $query = $this->getQuery();

        $subdistrictwhere = $whereArr->only($this->getFillable());
        if ($subdistrictwhere->isNotEmpty()) {
            $query = $query->where($subdistrictwhere->toArray());
        }

        if ($whereArr->has('search')) {
            $query = $query->where(DB::raw('TRIM(LOWER(subdistrictname))'), 'like', "%" . Str::lower($whereArr->get('search')) . "%");
        }

        return $query->get();
    }

    public function byName($name)
    {
        $subdistrict = null;
        $remain_count = 0;

        $name_lower = Str::lower($name);
        $subdistricts = $this->getQuery()->where(DB::raw('TRIM(LOWER(subdistrictname))'), 'like', "%$name_lower%")->get();
        foreach ($subdistricts as $key => $subdistrict) {
            $remain_characters = Str::replace($name_lower, '', Str::lower($subdistrict->subdistrictname));
            if ($key == 0) {
                $remain_count = strlen($remain_characters);
                $subdistrict = $subdistrict;
            } else {
                if (strlen($remain_characters) < $remain_count) {
                    $remain_count = strlen($remain_characters);
                    $subdistrict = $subdistrict;
                }
            }
        }

        return $subdistrict;
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'subdistrictcity' => function ($query) {
                $query->select('cityid', 'cityname');
            }
        ]);
    }
}
