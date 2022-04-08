<?php

namespace App\Services\Masters;

use App\Models\Masters\Types;

class TypeChildrenServices extends Types
{
    public function datatablesNonFilter()
    {
        return $this->newQuery()->select('*')->whereNotNull('typemasterid');
    }
    public function datatables($id)
    {
        return $this->newQuery()->select('*')->where('typemasterid', $id);
    }

    public function parent()
    {
        return $this->newQuery()->select('*')->where('typemasterid', null)->get();
    }

    public function showParent($id)
    {
        return $this->newQuery()->select('*')->where('typemasterid', null)->where('typeid', $id)
            ->findOrFail($id);
    }

    public function find($id)
    {
        return $this->newQuery()
            ->whereHas('parent', function ($query) use ($id) {
                $query->where('typeid', $id);
            })
            ->findOrFail($id);
    }
}
