<?php

namespace App\Services\Masters;

use App\Models\Masters\Types;
use Illuminate\Support\Facades\DB;

class TypeServices extends Types
{

    public function byCodes($code)
    {
        return $this->newQuery()->select('typeid')
            ->where('typecd', $code)->get();
    }

    public function byCode($code)
    {
        return $this->newQuery()->select('typeid', 'typecd', 'typename', 'typeseq')
            ->whereHas('parent', function ($query) use ($code) {
                $query->where('typecd', $code);
            })
            ->orderBy('typename', 'asc')
            ->get();
    }

    public function bySeq($code)
    {
        return $this->newQuery()->select('typeid', 'typecd', 'typename', 'typeseq')
            ->whereHas('parent', function ($query) use ($code) {
                $query->where('typecd', $code);
            })
            ->orderBy('typeseq', 'asc')
            ->get();
    }

    public function byParentId($code)
    {
        return $this->newQuery()
            ->where('typemasterid', $code)
            ->orderBy('typename', 'asc')
            ->get();
    }

    public function datatables($order, $orderby, $search)
    {
        return $this->newQuery()->select('*')->where('typemasterid', null)
            ->where(function ($query) use ($search, $order) {
                $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
            })
            ->orderBy($order, $orderby);
    }

    public function find($id)
    {
        return $this->newQuery()
            ->findOrFail($id);
    }
}
