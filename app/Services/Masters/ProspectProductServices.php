<?php

namespace App\Services\Masters;

use App\Models\Masters\Product;
use App\Models\Masters\ProspectProduct;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProspectProductServices extends ProspectProduct
{
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

    public function getAll(Collection $whereArr)
    {
        $query = $this->getQuery();

        $prospectwhere = $whereArr->only($this->fillable);
        if ($prospectwhere->isNotEmpty()) {
            $query = $query->where($prospectwhere->toArray());
        }

        if ($whereArr->has('search')) {
            $search = Str::lower($whereArr->get('search'));
            $query->whereHas('prosproductproduct', function ($q) use ($search) {
                $q->where(DB::raw('TRIM(LOWER(productname))'), 'like', "%$search%");
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

    public function updateProspectProduct($id, Collection $data)
    {
        $prospectProduct = $this->find($id)->fill($data->toArray());
        $prospectProduct->save();
        Product::find($prospectProduct->prosproductproductid)->fill($data->toArray())->save();
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'prospectproductcreatedby',
            'prospectproductupdatedby',
            'prosproductproduct',
            'prosproductprospect',
            'prosproducttaxtype' => function ($query) {
                $query->select('typeid', 'typename');
            },
        ]);
    }
}
