<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\ProspectCustomField;
use App\Models\Masters\ProspectProduct;
use App\Services\Masters\ProspectCustomFieldServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProspectCustomFieldController extends Controller
{

    public function all(Request $req, ProspectCustomFieldServices $ProspectServices)
    {
        $Prospects = $ProspectServices->getAll(collect($req->all()));
        return response()->json($Prospects);
    }

    public function store(Request $req, ProspectCustomField $ProspectCustomFieldModel)
    {
        $insert = collect($req->only($ProspectCustomFieldModel->getFillable()))->filter()->except('updatedby');

        $ProspectCustomFieldModel->fill($insert->toArray())->save();

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ProspectCustomFieldServices $ProspectServices)
    {
        $Prospect = $ProspectServices->find($id);
        return response()->json($Prospect);
    }

    public function update($id, Request $req, ProspectCustomField $ProspectCustomFieldModel)
    {

        $fields = collect($req->only($ProspectCustomFieldModel->getFillable()))->filter()
            ->except('createdby', 'prospectid');
        $ProspectCustomFieldModel->findOrFail($id)->update($fields->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, ProspectCustomField $ProspectCustomFieldModel)
    {
        $ProspectCustomFieldModel->findOrFail($id)->delete();
        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
