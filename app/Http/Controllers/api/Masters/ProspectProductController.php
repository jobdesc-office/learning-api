<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\ProspectProductServices;
use App\Services\Masters\SubdistrictServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProspectProductController extends Controller
{
    public function datatables(ProspectProductServices $cityservice)
    {
        $query = $cityservice->datatables();

        return datatables()->eloquent($query)
            ->toJson();
    }

    public function all(Request $req, ProspectProductServices $prospectProduct)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $prospectProduct->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, ProspectProductServices $modelProspectProductServices)
    {
        $insert = collect($req->only($modelProspectProductServices->getFillable()))->filter()
            ->except('updatedby');

        $modelProspectProductServices->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ProspectProductServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, ProspectProductServices $modelProspectProductServices)
    {
        $row = $modelProspectProductServices->findOrFail($id);

        $update = collect($req->only($modelProspectProductServices->getFillable()))->filter()
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, ProspectProductServices $modelProspectProductServices, SubdistrictServices $subdistrictservice)
    {
        DB::beginTransaction();
        try {
            $modelProspectProductServices->findOrFail($id)->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
