<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\OptionServices;
use Illuminate\Http\Request;

class OptionController extends Controller
{

    public function store(Request $req, OptionServices $modelOptionServices)
    {
        $insert = collect($req->only($modelOptionServices->getFillable()))->filter()->except('updatedby');

        $modelOptionServices->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, OptionServices $Optionservices)
    {
        $row = $Optionservices->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, OptionServices $modelOptionServices)
    {
        $row = $modelOptionServices->findOrFail($id);

        $update = collect($req->only($modelOptionServices->getFillable()))
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, OptionServices $modelOptionServices)
    {
        $row = $modelOptionServices->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
