<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\ProspectProduct;
use App\Services\Masters\ProspectDetailServices;
use App\Services\Masters\ProspectProductServices;
use App\Services\Masters\SubdistrictServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProspectDetailController extends Controller
{
    public function datatables(ProspectDetailServices $cityservice)
    {
        $query = $cityservice->datatables();

        return datatables()->eloquent($query)
            ->toJson();
    }

    public function all(Request $req, ProspectDetailServices $prospectService)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $prospectService->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, ProspectDetailServices $modelProspectDetailServices)
    {
        $insert = collect($req->toArray())->filter()
            ->except('updatedby');

        $modelProspectDetailServices->create($insert->toArray());

        if ($insert->has('products')) {
            foreach ($insert->get('products') as $product) {
                $prospectProductServices = new ProspectProductServices;
                $prospectProductServices->createProspectProduct(collect($product));
            }
        }

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ProspectDetailServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, ProspectDetailServices $modelProspectDetailServices)
    {
        $row = $modelProspectDetailServices->findOrFail($id);

        $update = collect($req->only($modelProspectDetailServices->getFillable()))->filter()
            ->except('createdby');
        $row->fill($update->toArray())->save();

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, ProspectDetailServices $modelProspectDetailServices, SubdistrictServices $subdistrictservice)
    {
        DB::beginTransaction();
        try {
            $modelProspectDetailServices->findOrFail($id)->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
