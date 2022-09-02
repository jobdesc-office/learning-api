<?php

namespace App\Services\Masters;

use App\Models\Masters\Types;
use Illuminate\Support\Facades\DB;

class TypeChildrenServices extends Types
{
    public function datatablesNonFilter($order, $orderby, $search)
    {
        return $this->newQuery()->select('*')->where('typemasterid', '!=', null)
            ->with([
                'typecreatedby',
                'typeupdatedby',
            ])
            ->where(function ($query) use ($search, $order) {
                $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
            })
            ->orderBy($order, $orderby);
    }
    public function datatables($id)
    {
        return $this->newQuery()->select('*')
            ->with([
                'typecreatedby',
                'typeupdatedby',
            ])->where('typemasterid', $id);
    }

    public function parents($searchValue)
    {
        return $this->newQuery()->select('typeid', 'typename')
            ->with([
                'typecreatedby',
                'typeupdatedby',
            ])
            ->where('typemasterid', null)
            ->where(function ($query) use ($searchValue) {
                $query->where(DB::raw('TRIM(LOWER(typename))'), 'like', "%$searchValue%");
            })
            ->orderBy('typename', 'asc')
            ->get();
    }

    public function showParent($id)
    {
        return $this->newQuery()
            ->with([
                'typecreatedby',
                'typeupdatedby',
            ])->select('*')->where('typemasterid', null)->where('typeid', $id)
            ->findOrFail($id);
    }

    public function children($searchValue)
    {
        return $this->newQuery()->select('*')
            ->with([
                'typecreatedby',
                'typeupdatedby',
            ])
            ->where(function ($query) use ($searchValue) {
                $query->where(DB::raw('TRIM(LOWER(typename))'), 'like', "%$searchValue%");
            })
            ->whereNotNull('typemasterid')
            ->orderBy('typename', 'asc')
            ->get();
    }

    public function find($id)
    {
        return $this->newQuery()
            ->with([
                'typecreatedby',
                'typeupdatedby',
            ])
            ->whereHas('parent', function ($query) use ($id) {
                $query->where('typeid', $id);
            })
            ->findOrFail($id);
    }
}
