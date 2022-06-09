<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\ProvinceServices;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{

    public function select(Request $req, ProvinceServices $provinceservice)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $provinceservice->select($searchValue);

        return response()->json($selects);
    }

    public function datatables(Request $req, ProvinceServices $provinceservice)
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
        $query = $provinceservice->datatables($order, $orderby);

        return datatables()->eloquent($query)
            ->toJson();
    }

    public function all(Request $req, ProvinceServices $bpcustomerservice)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $bpcustomerservice->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, ProvinceServices $modelProvinceServices)
    {
        $insert = collect($req->only($modelProvinceServices->getFillable()))->filter()->except('updatedby');

        $modelProvinceServices->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ProvinceServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, ProvinceServices $modelProvinceServices)
    {
        $row = $modelProvinceServices->findOrFail($id);

        $update = collect($req->only($modelProvinceServices->getFillable()))->filter()
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, ProvinceServices $modelProvinceServices)
    {
        $row = $modelProvinceServices->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }

    public function byName(Request $req, ProvinceServices $modelProvinceServices)
    {
        $filtered = collect($req->all())->filter();
        $row = $modelProvinceServices->byName($filtered->get('name'));
        return response()->json($row);
    }
}
