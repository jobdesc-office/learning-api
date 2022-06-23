<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\ProspectDetailServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProspectDetailController extends Controller
{

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

    public function destroy($id, ProspectDetailServices $modelProspectDetailServices)
    {
        $modelProspectDetailServices->find($id)->delete();
        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
