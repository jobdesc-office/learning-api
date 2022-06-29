<?php

namespace App\Services\Masters;

use App\Models\Masters\ProspectCustomField;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProspectCustomFieldServices extends ProspectCustomField
{

    public function find($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function getAll(Collection $whereArr)
    {
        $query = $this->getQuery();

        $ProspectCustomFieldwhere = $whereArr->only($this->getFillable());
        if ($ProspectCustomFieldwhere->isNotEmpty()) {
            $query = $query->where($ProspectCustomFieldwhere->toArray());
        }

        return $query->get();
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'customfield',
            'prospect'
        ]);
    }
}