<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\ProspectProductServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProspectProductController extends Controller
{

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

    public function destroy($id, ProspectProductServices $modelProspectProductServices)
    {
        $modelProspectProductServices->find($id)->delete();
        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
