<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\TypeServices;
use App\Models\Masters\Types;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypesController extends Controller
{

    public function byCode(Request $req, TypeServices $typeServices)
    {
        $types = $typeServices->byCode($req->get('typecd'));
        return response()->json($types);
    }

    public function datatables(TypeServices $typeServices)
    {
        $query = $typeServices->datatables();

        return
            datatables()->eloquent($query)
            ->toJson()
            ->getOriginalContent();
    }

    public function store(Request $req, Types $modelTypes)
    {
        $insert = collect($req->only($modelTypes->getFillable()))->filter()->except('updatedby');

        $modelTypes->fill($insert->toArray())->save();

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, TypeServices $typeServices)
    {
        $row = $typeServices->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, Types $modelTypes)
    {
        $row = $modelTypes->findOrFail($id);

        $update = collect($req->only($modelTypes->getFillable()))->filter()
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, Types $modelTypes)
    {
        DB::beginTransaction();
        try {
            $modelTypes->select('typeid')->where('typemasterid', $id)->delete();
            $modelTypes->findOrFail($id)->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
