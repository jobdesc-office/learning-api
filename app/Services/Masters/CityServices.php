<?php

namespace App\Services\Masters;

use App\Models\Masters\City;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CityServices extends City
{
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
            $query = $query->where(DB::raw('TRIM(LOWER(cityname))'), 'like', "%" . $whereArr->get('search') . "%");
        }

        return $query->get();
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
