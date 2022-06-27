<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\ProspectActivity;
use App\Models\Masters\ProspectProduct;
use App\Services\Masters\ProspectActivityServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProspectActivityController extends Controller
{
    public function details(Request $req, ProspectActivityServices $ProspectDetailServices)
    {
        $id = $req->get('id');
        $query = $ProspectDetailServices->details($id);

        return $query->get();
    }

    public function all(Request $req, ProspectActivityServices $ProspectServices)
    {
        $Prospects = $ProspectServices->getAll(collect($req->all()));
        return response()->json($Prospects);
    }

    public function store(Request $req, ProspectActivity $ProspectDetailModel, ProspectProduct $ProspectProduct)
    {
        $insert = collect($req->only($ProspectDetailModel->getFillable()))->filter()->except('updatedby');

        $ProspectDetailModel->fill($insert->toArray())->save();

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ProspectActivityServices $ProspectServices)
    {
        $Prospect = $ProspectServices->find($id);
        return response()->json($Prospect);
    }

    public function update($id, Request $req, ProspectActivity $ProspectDetailModel, ProspectProduct $ProspectProduct)
    {

        $fields = collect($req->only($ProspectDetailModel->getFillable()))->filter()
            ->except('createdby', 'prospectdtprospectid');
        $ProspectDetailModel->findOrFail($id)->update($fields->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, ProspectActivity $ProspectDetailModel, ProspectProduct $ProspectProduct)
    {
        $ProspectDetailModel->findOrFail($id)->delete();
        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
