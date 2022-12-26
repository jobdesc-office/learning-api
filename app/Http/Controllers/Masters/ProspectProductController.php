<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\ProspectProduct;
use App\Services\Masters\BpQuotaServices;
use App\Services\Masters\ProspectProductServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProspectProductController extends Controller
{

    public function all(Request $req, ProspectProductServices $ProspectServices)
    {
        $Prospects = $ProspectServices->getAll(collect($req->all()));
        return response()->json($Prospects);
    }

    public function store(Request $req, ProspectProduct $ProspectProductModel, BpQuotaServices $quotaServices)
    {
        if (!$quotaServices->isAllowAddProduct(1)) return response()->json(['message' => "Product " . \TextMessages::limitReached], 400);
        $insert = collect($req->only($ProspectProductModel->getFillable()))->filter()->except('updatedby');

        $ProspectProductModel->fill($insert->toArray())->save();

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ProspectProductServices $ProspectServices)
    {
        $Prospect = $ProspectServices->find($id);
        return response()->json($Prospect);
    }

    public function update($id, Request $req, ProspectProduct $ProspectProductModel)
    {

        $fields = collect($req->only($ProspectProductModel->getFillable()))
            ->except('createdby', 'prosproductproductid');
        $ProspectProductModel->findOrFail($id)->update($fields->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, ProspectProduct $ProspectProductModel)
    {
        $ProspectProductModel->findOrFail($id)->delete();
        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
