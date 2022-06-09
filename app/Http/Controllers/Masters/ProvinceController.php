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
