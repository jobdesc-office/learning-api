<?php

namespace App\Services\Masters;

use App\Models\Masters\Country;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CountryServices extends Country
{

    public function select($searchValue)
    {
        return $this->newQuery()->select('*')
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(countryname))'), 'like', "%$searchValue%");
            })
            ->get();
    }

    public function datatables()
    {
        return $this->newQuery()->select('*');
    }

    public function find($id)
    {
        return $this->newQuery()->findOrFail($id);
    }

    public function getAll(Collection $whereArr)
    {
        $query = $this->newQuery();

        $countrywhere = $whereArr->only($this->fillable);
        if ($countrywhere->isNotEmpty()) {
            $query = $query->where($countrywhere->toArray());
        }

        if ($whereArr->has('search')) {
            $query = $query->where(DB::raw('TRIM(LOWER(countryname))'), 'like', "%" . Str::lower($whereArr->get('search')) . "%");
        }

        return $query->get();
    }

    public function byName($name)
    {
        $country = null;
        $remain_count = 0;

        $name_lower = Str::lower($name);
        $countrys = $this->getQuery()->where(DB::raw('TRIM(LOWER(countryname))'), 'like', "%$name_lower%")->get();
        foreach ($countrys as $key => $country) {
            $remain_characters = Str::replace($name_lower, '', Str::lower($country->countryname));
            if ($key == 0) {
                $remain_count = strlen($remain_characters);
                $country = $country;
            } else {
                if (strlen($remain_characters) < $remain_count) {
                    $remain_count = strlen($remain_characters);
                    $country = $country;
                }
            }
        }

        return $country;
    }
}
