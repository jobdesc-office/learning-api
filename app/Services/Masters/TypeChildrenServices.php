<?php

namespace App\Services\Masters;

use App\Models\Masters\Types;
use Illuminate\Support\Facades\DB;

class TypeChildrenServices extends Types
{
    public function datatablesNonFilter()
    {
        return $this->newQuery()->select('*');
    }
    public function datatables($id)
    {
        return $this->newQuery()->select('*')->where('typemasterid', $id);
    }

    public function parents($searchValue)
    {
        return $this->newQuery()->select('typeid', 'typename')
            ->where('typemasterid', null)
            ->where(function ($query) use ($searchValue) {
                $query->where(DB::raw('TRIM(LOWER(typename))'), 'like', "%$searchValue%");
            })
            ->get();
    }

    public function showParent($id)
    {
        return $this->newQuery()->select('*')->where('typemasterid', null)->where('typeid', $id)
            ->findOrFail($id);
    }

    public function children($searchValue)
    {
        return $this->newQuery()->select('*')
            ->where(function ($query) use ($searchValue) {
                $query->where(DB::raw('TRIM(LOWER(typename))'), 'like', "%$searchValue%");
            })
            ->whereNotNull('typemasterid')
            ->get();
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
