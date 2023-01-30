<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\OptionServices;
use App\Models\Masters\ProspectCustomField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function destroy($id, OptionServices $modelOptionServices, ProspectCustomField $prospectCustomField)
    {
        DB::beginTransaction();
        try {
            $prospectCustomField->where('optchoosed', $id)->delete();
            $row = $modelOptionServices->findOrFail($id);
            $row->delete();

            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => \TextMessages::failedDelete, 'error' => $th]);
        }
    }
}
