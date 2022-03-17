<?php

namespace App\Services;

use App\Models\Masters\Types;

class TypeServices extends Types
{

    public function whereParent($code)
    {
        return $this->newQuery()->select(['typeid', 'typecd', 'typename', 'masterid'])
            ->with([
                'parent' => function($query) {
                    $query->select('typeid', 'typecd', 'typename');
                }
            ])
            ->whereHas('parent', function($query) use ($code) {
                $query->where('typecd', $code);
            });
    }
}
