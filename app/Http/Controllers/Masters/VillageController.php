<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\VillageServices;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    public function datatables(Request $req, VillageServices $Villageservice)
    {
        $search = trim(strtolower($req->get('search[value]')));
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
        $query = $Villageservice->datatables($order, $orderby, $search);

        return
            datatables()->eloquent($query)
            ->toJson()
            ->getOriginalContent();
    }

    public function all(Request $req, VillageServices $bpcustomerservice)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $bpcustomerservice->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, VillageServices $modelVillageServices)
    {
        $insert = collect($req->only($modelVillageServices->getFillable()))->filter()->except('updatedby');

        $modelVillageServices->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, VillageServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, VillageServices $modelVillageServices)
    {
        $row = $modelVillageServices->findOrFail($id);

        $update = collect($req->only($modelVillageServices->getFillable()))
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, VillageServices $modelVillageServices)
    {
        $row = $modelVillageServices->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }

    public function byName(Request $req, VillageServices $modelVillageServices)
    {
        $filtered = collect($req->all())->filter();
        $row = $modelVillageServices->placesByName($filtered);
        return response()->json($row);
    }
}
