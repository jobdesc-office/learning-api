<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\ProspectAssign;
use App\Models\Masters\ProspectProduct;
use App\Services\Masters\ProspectAssignServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProspectAssignController extends Controller
{

    public function all(Request $req, ProspectAssignServices $ProspectServices)
    {
        $Prospects = $ProspectServices->getAll(collect($req->all()));
        return response()->json($Prospects);
    }

    public function store(Request $req, ProspectAssign $ProspectAssignModel)
    {
        $insert = collect($req->only($ProspectAssignModel->getFillable()))->filter()->except('updatedby');

        $ProspectAssignModel->fill($insert->toArray())->save();

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ProspectAssignServices $ProspectServices)
    {
        $Prospect = $ProspectServices->find($id);
        return response()->json($Prospect);
    }

    public function update($id, Request $req, ProspectAssign $ProspectAssignModel)
    {

        $fields = collect($req->only($ProspectAssignModel->getFillable()))
            ->except('createdby', 'prospectid');
        $ProspectAssignModel->findOrFail($id)->update($fields->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, ProspectAssign $ProspectAssignModel, ProspectProduct $ProspectProduct)
    {
        DB::beginTransaction();
        try {
            $ProspectProduct->select('prosproductid')->where('prosproductprospectid', $id)->delete();
            $ProspectAssignModel->findOrFail($id)->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
