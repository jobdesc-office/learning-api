<?php

namespace App\Services\Masters;

use App\Models\Masters\Province;
use Illuminate\Support\Collection;

class ProvinceServices extends Province
{
    public function find($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function getAll(Collection $whereArr)
    {
        $query = $this->getQuery();

        $provincewhere = $whereArr->only($this->fillable);
        if ($provincewhere->isNotEmpty()) {
            $query = $query->where($provincewhere->toArray());
        }

        return $query->get();
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'provcountry' => function ($query) {
                $query->select('countryid', 'countryname');
            }
        ]);
    }
}
