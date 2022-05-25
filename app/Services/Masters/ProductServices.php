<?php

namespace App\Services\Masters;

use App\Models\Masters\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductServices extends Product
{
    public function datatables()
    {
        return $this->getQuery();
    }

    public function find($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'businesspartner' => function ($query) {
                $query->select('bpid', 'bpname');
            }
        ]);
    }
}
