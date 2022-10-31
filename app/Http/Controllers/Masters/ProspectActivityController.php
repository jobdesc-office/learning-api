<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\ProspectActivity;
use App\Models\Masters\ProspectProduct;
use App\Services\Masters\ProspectActivityServices;

use App\Services\Masters\DailyActivityServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class ProspectActivityController extends Controller
{
    public function details(
        Request $req,
        DailyActivityServices $dailyActivityServices
    ) {
        $id = $req->get('id');
        $query = $dailyActivityServices->details($id);

        return $query->get();
    }

    public function all(Request $req, ProspectActivityServices $ProspectServices)
    {
        $Prospects = $ProspectServices->getAll(collect($req->all()));
        return response()->json($Prospects);
    }

    public function store(Request $req, DailyActivityServices $dailyActivityServices)
    {
        $prospecttype = find_type()->in([\DBTypes::dayactreftypeprospect])->get(\DBTypes::dayactreftypeprospect)->getId();

        $insert = collect($req->only($dailyActivityServices->getFillable()))->filter()->put('dayactreftypeid', $prospecttype)->except('updatedby');

        $dailyActivityServices->fill($insert->toArray())->save();

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, DailyActivityServices $dailyActivityServices)
    {
        $Prospect = $dailyActivityServices->find($id);
        return response()->json($Prospect);
    }

    public function update($id, Request $req, ProspectActivity $ProspectActivityModel, DailyActivityServices $dailyActivityServices)
    {

        $fields = collect($req->only($dailyActivityServices->getFillable()))
            ->except('createdby', 'prospectdtprospectid');
        $dailyActivityServices->findOrFail($id)->update($fields->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, ProspectActivity $ProspectActivityModel, DailyActivityServices $dailyActivityServices)
    {
        $dailyActivityServices->findOrFail($id)->delete();
        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
