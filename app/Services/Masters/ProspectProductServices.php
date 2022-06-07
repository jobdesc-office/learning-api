<?php

namespace App\Services\Masters;

use App\Models\Masters\ProspectProduct;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProspectProductServices extends ProspectProduct
{
    public function datatables()
    {
        return $this->getQuery();
    }

    public function find($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function getAll(Collection $whereArr)
    {
        $query = $this->getQuery();

        $prospectwhere = $whereArr->only($this->fillable);
        if ($prospectwhere->isNotEmpty()) {
            $query = $query->where($prospectwhere->toArray());
        }

        if ($whereArr->has('search')) {
            $query->whereHas('prosproductproduct', function ($q) use ($whereArr) {
                $q->where('productname', 'like', '%' . $whereArr->get('search') . '%');
            });
        }

        return $query->get();
    }

    public function createProspectProduct(Collection $data)
    {
        $productServices = new ProductServices;
        $product = $productServices->saveOrGet($data);

        $data = $data->only($this->getFillable());
        $this->fill($data->toArray());
        $this->prosproductproductid = $product->productid;

        return $this->save();
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'prosproductproduct',
            'prosproductprospect',
            'prosproducttaxtype' => function ($query) {
                $query->select('typeid', 'typename');
            },
        ]);
    }
}
