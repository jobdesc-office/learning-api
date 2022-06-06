<?php

namespace App\Services;

use App\Models\Masters\Types;
use DBTypes;
use Illuminate\Support\Facades\Log;

class TypeServices extends Types
{

    public function whereParent($code)
    {
        return $this->newQuery()->select(['typeid', 'typecd', 'typename', 'typemasterid'])
            ->with([
                'parent' => function ($query) {
                    $query->select('typeid', 'typecd', 'typename');
                }
            ])
            ->whereHas('parent', function ($query) use ($code) {
                $query->whereIn('typecd', array_merge([], $code));
            });
    }
}
