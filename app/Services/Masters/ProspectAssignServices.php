<?php

namespace App\Services\Masters;

use App\Models\Masters\ProspectAssign;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProspectAssignServices extends ProspectAssign
{
    public function find($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function getAll(Collection $whereArr)
    {
        $query = $this->getQuery();

        $prospectassignwhere = $whereArr->only($this->getFillable());
        if ($prospectassignwhere->isNotEmpty()) {
            $query = $query->where($prospectassignwhere->toArray());
        }

        return $query->get();
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'prospectassigncreatedby',
            'prospectassignupdatedby',
            'prospectassign' => function ($query) {
                $query->with(['user', 'usertype', 'businesspartner']);
            },
            'prospectreport' => function ($query) {
                $query->with(['user', 'usertype', 'businesspartner']);
            },
            'prospect',
        ]);
    }
}
