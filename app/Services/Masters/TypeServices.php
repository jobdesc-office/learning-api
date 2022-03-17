<?php

namespace App\Services\Masters;

use App\Models\Masters\Types;

class TypeServices extends Types
{

    public function byCode($code)
    {
        return $this->newQuery()->select('typeid', 'typecd', 'typename')
            ->whereHas('parent', function($query) use ($code) {
                $query->where('typecd', $code);
            })
            ->get();
    }
}
