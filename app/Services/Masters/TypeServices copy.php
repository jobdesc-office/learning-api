<?php

namespace App\Services\Masters;

use App\Models\Masters\Types;
use Illuminate\Support\Facades\DB;

class TypeServices extends Types
{

    public function byCodes($code)
    {
        return $this->newQuery()->select('typeid')
            ->with([
                'typecreatedby',
                'typeupdatedby',
            ])
            ->where('typecd', $code)->get();
    }

    public function byCodeAdd($code, $searchValue)
    {
        return $this->newQuery()->select('typeid', 'typecd', 'typename', 'typeseq', 'typemasterid')
            ->whereHas('parent', function ($query) use ($code) {
                $query->where('typecd', $code);
            })
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(typename))'), 'like', "%$searchValue%");
            })
            ->with([
                'typecreatedby',
                'typeupdatedby',
            ])
            ->orderBy('typename', 'asc')
            ->get();
    }

    public function byCode($code, $search = "")
    {
        return $this->newQuery()->select('typeid', 'typecd', 'typename', 'typeseq', 'typemasterid')
            ->whereHas('parent', function ($query) use ($code) {
                $query->where('typecd', $code);
            })
            ->where(DB::raw('TRIM(LOWER(typename))'), 'like', "%$search%")
            ->with([
                'typecreatedby',
                'typeupdatedby',
            ])
            ->orderBy('typename', 'asc')
            ->get();
    }

    public function byCodeMaster($code)
    {
        return $this->newQuery()
            ->where('typecd', $code)
            ->with([
                'typecreatedby',
                'typeupdatedby',
            ])
            ->get();
    }

    public function bySeq($code)
    {
        return $this->newQuery()->select('typeid', 'typecd', 'typename', 'typeseq')
            ->whereHas('parent', function ($query) use ($code) {
                $query->where('typecd', $code);
            })
            ->with([
                'typecreatedby',
                'typeupdatedby',
            ])
            ->orderBy('typeseq', 'asc')
            ->get();
    }

    public function byParentId($code)
    {
        return $this->newQuery()
            ->with([
                'typecreatedby',
                'typeupdatedby',
                'childrens',
            ])
            ->where('typemasterid', $code)
            ->orderBy('typename', 'asc')
            ->get();
    }

    public function datatables($order, $orderby, $search)
    {
        return $this->newQuery()->select('*')->where('typemasterid', null)
            ->with([
                'typecreatedby',
                'typeupdatedby',
            ])
            ->where(function ($query) use ($search, $order) {
                $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
            })
            ->orderBy($order, $orderby);
    }

    public function find($id)
    {
        return $this->newQuery()
            ->with([
                'typecreatedby',
                'typeupdatedby',
            ])
            ->findOrFail($id);
    }
}