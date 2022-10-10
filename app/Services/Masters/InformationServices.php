<?php

namespace App\Services\Masters;

use App\Models\Masters\Information;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class InformationServices extends Information
{

    public function byname($name)
    {
        return $this->getQuery()
            ->where('infoname', $name)
            ->orderBy('infoname', 'asc')
            ->first();
    }

    public function datatables($order, $orderby, $search)
    {
        return $this->getQuery()
            ->where(function ($query) use ($search, $order) {
                $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
            })
            ->orderBy($order, $orderby);
    }

    public function find($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'infocreatedby', 'infoupdatedby'
        ]);
    }
}
