<?php

namespace App\Services\Masters;

use App\Models\Masters\City;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CityServices extends City
{

    public function select($searchValue)
    {
        return $this->getQuery()->select('*')
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(cityname))'), 'like', "%$searchValue%");
            })
            ->get();
    }

    public function datatables()
    {
        return $this->getQuery();
    }

    public function find($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function getAll(Collection $whereArr)
    {
        $query = $this->getQuery();

        $citywhere = $whereArr->only($this->fillable);
        if ($citywhere->isNotEmpty()) {
            $query = $query->where($citywhere->toArray());
        }

        if ($whereArr->has("search")) {
            $query = $query->where(DB::raw('TRIM(LOWER(cityname))'), 'like', "%" . Str::lower($whereArr->get('search')) . "%");
        }

        return $query->get();
    }

    public function byName($name)
    {
        $city = null;
        $remain_count = 0;

        $name_lower = Str::lower($name);
        $citys = $this->getQuery()->where(DB::raw('TRIM(LOWER(cityname))'), 'like', "%$name_lower%")->get();
        foreach ($citys as $key => $city) {
            $remain_characters = Str::replace($name_lower, '', Str::lower($city->cityname));
            if ($key == 0) {
                $remain_count = strlen($remain_characters);
                $city = $city;
            } else {
                if (strlen($remain_characters) < $remain_count) {
                    $remain_count = strlen($remain_characters);
                    $city = $city;
                }
            }
        }

        return $city;
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'cityprov' => function ($query) {
                $query->select('provid', 'provname');
            }
        ]);
    }
}
