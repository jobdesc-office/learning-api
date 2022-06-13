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
