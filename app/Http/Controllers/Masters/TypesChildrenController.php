<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\TypeChildrenServices;
use App\Models\Masters\Types;
use Illuminate\Http\Request;

class TypesChildrenController extends Controller
{
    public function datatablesNonFilter(Request $req, TypeChildrenServices $typeChildrenServices)
    {
        $order = $req->get('order[0][column]');
        $orderby = $req->get('order[0][dir]');

        if ($order == 0) {
            $order = $req->get('columns[0][data]');
        } elseif ($order == 1) {
            $order = $req->get('columns[1][data]');
        } elseif ($order == 2) {
            $order = $req->get('columns[2][data]');
        } elseif ($order == 3) {
            $order = $req->get('columns[3][data]');
        } elseif ($order == 4) {
            $order = $req->get('columns[4][data]');
        } elseif ($order == 5) {
            $order = $req->get('columns[5][data]');
        } elseif ($order == 6) {
            $order = $req->get('columns[6][data]');
        } elseif ($order == 7) {
            $order = $req->get('columns[7][data]');
        } elseif ($order == 8) {
            $order = $req->get('columns[8][data]');
        } elseif ($order == 9) {
            $order = $req->get('columns[9][data]');
        } else {
            $order = $order;
        }
        $query = $typeChildrenServices->datatablesNonFilter($order, $orderby);

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
        $insert = collect($req->only($modelTypes->getFillable()))->filter()->except('updatedby');

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
