<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\TypeChildrenServices;
use App\Models\Masters\Types;
use Illuminate\Http\Request;

class TypesChildrenController extends Controller
{
    public function datatablesNonFilter(TypeChildrenServices $typeChildrenServices)
    {
        $query = $typeChildrenServices->datatablesNonFilter();

        return datatables()->eloquent($query)
            ->toJson();
    }
    public function datatables($id, TypeChildrenServices $typeChildrenServices)
    {
        $query = $typeChildrenServices->datatables($id);

        return datatables()->eloquent($query)
            ->toJson();
    }

    public function store(Request $req, Types $modelTypes)
    {
        $insert = collect($req->only($modelTypes->getFillable()))->filter();

        $modelTypes->fill($insert->toArray())->save();

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function parent(Request $req, TypeChildrenServices $typeChildrenServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $query = $typeChildrenServices->parents($searchValue);

        return response()->json($query);
    }

    public function showParent($id, TypeChildrenServices $typeChildrenServices)
    {
        $query = $typeChildrenServices->showParent($id);

        return response()->json($query);
    }

    public function children(Request $req, TypeChildrenServices $typeChildrenServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $query = $typeChildrenServices->children($searchValue);

        return response()->json($query);
    }

    public function show($id, TypeChildrenServices $typeChildrenServices)
    {
        $row = $typeChildrenServices->find($id);
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
        $row = $modelTypes->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
