<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\ProspectAssignServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProspectAssignController extends Controller
{
    public function all(Request $req, ProspectAssignServices $bpcustomerservice)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $bpcustomerservice->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, ProspectAssignServices $modelProspectAssignServices)
    {
        $insert = collect($req->all())->filter()
            ->except('updatedby');

        $modelProspectAssignServices->fill($insert->toArray())->save();

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ProspectAssignServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, ProspectAssignServices $modelProspectAssignServices)
    {
        $row = $modelProspectAssignServices->findOrFail($id);

        $update = collect($req->only($modelProspectAssignServices->getFillable()))->filter()
            ->except('createdby');
        $row->fill($update->toArray())->save();

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, ProspectAssignServices $modelProspectAssignServices)
    {
        $modelProspectAssignServices->findOrFail($id)->delete();
        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
