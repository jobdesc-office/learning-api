<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\SubdistrictServices;
use Illuminate\Http\Request;

class SubdistrictController extends Controller
{
    public function datatables(Request $req, SubdistrictServices $subdistrictservice)
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
        $query = $subdistrictservice->datatables($order, $orderby);

        return datatables()->eloquent($query)
            ->toJson();
    }

    public function all(Request $req, SubdistrictServices $bpcustomerservice)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $bpcustomerservice->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, SubdistrictServices $modelSubdistrictServices)
    {
        $insert = collect($req->only($modelSubdistrictServices->getFillable()))->filter()->except('updatedby');

        $modelSubdistrictServices->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, SubdistrictServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, SubdistrictServices $modelSubdistrictServices)
    {
        $row = $modelSubdistrictServices->findOrFail($id);

        $update = collect($req->only($modelSubdistrictServices->getFillable()))->filter()
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, SubdistrictServices $modelSubdistrictServices)
    {
        $row = $modelSubdistrictServices->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }

    public function byName(Request $req, SubdistrictServices $modelSubdistrictServices)
    {
        $filtered = collect($req->all())->filter();
        $row = $modelSubdistrictServices->byName($filtered->get('name'));
        return response()->json($row);
    }
}
