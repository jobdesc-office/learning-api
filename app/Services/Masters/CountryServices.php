<?php

namespace App\Services\Masters;

use App\Models\Masters\Country;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CountryServices extends Country
{
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
}
