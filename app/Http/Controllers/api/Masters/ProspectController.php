<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\ProspectAssignServices;
use App\Services\Masters\ProspectDetailServices;
use App\Services\Masters\ProspectProductServices;
use App\Services\Masters\ProspectServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProspectController extends Controller
{
    public function datatables(ProspectServices $cityservice)
    {
        $query = $cityservice->datatables();

        return datatables()->eloquent($query)
            ->toJson();
    }

    public function all(Request $req, ProspectServices $prospectService)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $prospectService->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, ProspectServices $modelProspectServices)
    {
        $insert = collect($req->all())->filter()->except('updatedby');

        $modelProspectServices->fill($insert->toArray())->save();

        if ($insert->has('products')) {
            foreach ($insert->get('products') as $product) {
                $productData = collect($product);
                $productData->put('prosproductprospectid', $modelProspectServices->prospectid);

                $prospectProductServices = new ProspectProductServices();
                $prospectProductServices->createProspectProduct($productData);
            }
        }

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ProspectServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, ProspectServices $modelProspectServices)
    {
        $row = $modelProspectServices->findOrFail($id);

        $update = collect($req->only($modelProspectServices->getFillable()))->filter()
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, ProspectServices $modelProspectServices, ProspectDetailServices $modelProspectDetail, ProspectProductServices $modelProspectProduct, ProspectAssignServices $modelProspectAssign)
    {
        DB::beginTransaction();
        try {
            $modelProspectAssign->where('prospectid', $id)->delete();
            $modelProspectDetail->where('prosproductprospectid', $id)->delete();
            $modelProspectProduct->where('prospectid', $id)->delete();
            $modelProspectServices->findOrFail($id)->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
