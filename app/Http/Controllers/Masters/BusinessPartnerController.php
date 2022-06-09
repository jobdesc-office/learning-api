<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\BusinessPartner;
use App\Services\Masters\BusinessPartnerServices;
use Illuminate\Http\Request;

class BusinessPartnerController extends Controller
{

    public function select(Request $req, BusinessPartnerServices $businessPartnerServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $businessPartnerServices->select($searchValue);

        return response()->json($selects);
    }

    public function datatables(Request $req, BusinessPartnerServices $businessPartnerServices)
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
        $query = $businessPartnerServices->datatables($order, $orderby);

        return datatables()->eloquent($query)
            ->toJson();
    }

    public function all(Request $req, BusinessPartnerServices $businessPartnerServices)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $businessPartnerServices->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, BusinessPartner $modelBusinessPartner)
    {
        $insert = collect($req->only($modelBusinessPartner->getFillable()))->filter()->except('updatedby');

        $modelBusinessPartner->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, BusinessPartnerServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, BusinessPartner $modelBusinessPartner)
    {
        $row = $modelBusinessPartner->findOrFail($id);

        $update = collect($req->only($modelBusinessPartner->getFillable()))->filter()
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, BusinessPartner $modelBusinessPartner)
    {
        $row = $modelBusinessPartner->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
