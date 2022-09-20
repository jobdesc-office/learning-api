<?php

namespace App\Services\Masters;

use App\Models\Masters\ActivityCustomField;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ActivityCustomFieldService extends ActivityCustomField
{
    public function getAll(Collection $whereArr)
    {
        $query = $this->getQuery();

        $bpCustomFieldwhere = $whereArr->only($this->getFillable());
        if ($bpCustomFieldwhere->isNotEmpty()) {
            $query = $query->where($bpCustomFieldwhere->toArray());
        }

        if ($whereArr->has('search')) {
            $query = $query->where(DB::raw('TRIM(LOWER(cstmname))'), 'like', "%" . Str::lower($whereArr->get('search')) . "%");
        }

        return $query->get();
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'custfcreatedby',
            'custfupdatedby',
            'businesspartner' => function ($query) {
                $query->select('bpid', 'bpname');
            },
            'custftype' => function ($query) {
                $query->select('typeid', 'typename');
            }
        ]);
    }
}
