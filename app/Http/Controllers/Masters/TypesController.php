<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\TypeServices;
use App\Models\Masters\Types;
use Illuminate\Http\Request;

class TypesController extends Controller
{

    public function byCode(Request $req, TypeServices $typeServices)
    {
        $types = $typeServices->byCode($req->get('typecd'));
        return response()->json($types);
    }

    public function datatables(Request $req, TypeServices $typeServices)
    {
        $order = $req->get('order[0][column]');
        $orderby = $req->get('order[0][dir]');

        switch ($order) {
            case 0:
                $order = $req->get('columns[0][data]');
                break;
            case 1:
                $order = $req->get('columns[1][data]');
                break;
            case 2:
                $order = $req->get('columns[2][data]');
                break;

            case 3:
                $order = $req->get('columns[3][data]');
                break;

            case 4:
                $order = $req->get('columns[4][data]');
                break;

            case 5:
                $order = $req->get('columns[5][data]');
                break;

            case 6:
                $order = $req->get('columns[6][data]');
                break;

            case 7:
                $order = $req->get('columns[7][data]');
                break;

            case 8:
                $order = $req->get('columns[8][data]');
                break;

            case 9:
                $order = $req->get('columns[9][data]');
                break;

            default:
                $order = $order;
                break;
        }
        $query = $typeServices->datatables($order, $orderby);

        return datatables()->eloquent($query)
            ->toJson();
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
        $row = $modelTypes->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
