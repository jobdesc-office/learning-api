<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\BusinessPartner;
use App\Services\Masters\BusinessPartnerServices;
use Illuminate\Http\Request;

class BusinessPartnerController extends Controller
{
    public function datatables(Request $req, BusinessPartnerServices $businessPartnerServices)
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
