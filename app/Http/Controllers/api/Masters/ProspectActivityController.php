<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\ProspectActivityServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProspectActivityController extends Controller
{

    public function all(Request $req, ProspectActivityServices $prospectService)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $prospectService->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, ProspectActivityServices $modelProspectActivityServices)
    {
        $insert = collect($req->toArray())->filter()
            ->except('updatedby');
        $modelProspectActivityServices->create($insert->toArray());
        // $modelProspectActivityServices->fill($insert->toArray());
        // $modelProspectActivityServices->save();

        return response()->json($modelProspectActivityServices);
    }

    public function show($id, ProspectActivityServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, ProspectActivityServices $modelProspectActivityServices)
    {
        $row = $modelProspectActivityServices->findOrFail($id);

        $update = collect($req->only($modelProspectActivityServices->getFillable()))->filter()
            ->except('createdby');
        $row->fill($update->toArray())->save();

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, ProspectActivityServices $modelProspectActivityServices)
    {
        $modelProspectActivityServices->find($id)->delete();
        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
