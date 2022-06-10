<?php

namespace App\Services\Masters;

use App\Models\Masters\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductServices extends Product
{
    public function datatables($order, $orderby, $search)
    {
        return $this->getQuery()
            ->where(function ($query) use ($search, $order) {
                $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
            })
            ->orderBy($order, $orderby);
    }

    public function selectwithbp($searchValue, $id)
    {
        return $this->getQuery()->select('*')
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(productname))'), 'like', "%$searchValue%");
            })
            ->where('productbpid', $id)
            ->get();
    }

    public function select($searchValue)
    {
        return $this->getQuery()->select('*')
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(productname))'), 'like', "%$searchValue%");
            })
            ->get();
    }

    public function saveOrGet(Collection $insert)
    {
        $insert = $insert->only($this->getFillable());
        $product = $this->getQuery()->where('productname', $insert->get('productname'))->get();
        if ($product->isEmpty()) {
            $this->fill($insert->toArray())->save();
            return $this;
        } else {
            return $product->first();
        }
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
