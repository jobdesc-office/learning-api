<?php

namespace App\Services\Masters;

use App\Models\Masters\Types;
use Illuminate\Support\Facades\DB;

class TypeServices extends Types
{

    public function byCode($code)
    {
        return $this->newQuery()->select('typeid', 'typecd', 'typename')
            ->whereHas('parent', function ($query) use ($code) {
                $query->where('typecd', $code);
            })
            ->get();
    }

    public function select($searchValue)
    {
        return $this->newQuery()->select('typeid', 'typename')
            ->where('typemasterid', 1)
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(typename))'), 'like', "%$searchValue%");
            })
            ->get();
    }

    public function datatables()
    {
        return $this->newQuery()->select('*')->where('typemasterid', null);
    }

    public function find($id)
    {
        return $this->newQuery()
            ->findOrFail($id);
    }
}
