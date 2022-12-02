<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\BusinessPartner;
use App\Services\Masters\BusinessPartnerServices;
use App\Models\Masters\Stbptype;
use Database\Seeders\BpTypeSeeder;
use Illuminate\Http\Request;
use DBTypes;

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
        $query = $businessPartnerServices->datatables($order, $orderby, $search);

        return
            datatables()->eloquent($query)
            ->toJson()
            ->getOriginalContent();
    }

    public function all(Request $req, BusinessPartnerServices $businessPartnerServices)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $businessPartnerServices->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, BusinessPartner $modelBusinessPartner, Stbptype $stbptype)
    {
        $insert = collect($req->only($modelBusinessPartner->getFillable()))->filter()->except('updatedby');

        $bp = $modelBusinessPartner->create($insert->toArray());
        $seeder = new BpTypeSeeder;
        $seeder->run($bp->bpid);
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

        $update = collect($req->only($modelBusinessPartner->getFillable()))
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

    public function setdayact($id, Request $req, BusinessPartner $modelBusinessPartner)
    {
        $row = $modelBusinessPartner->findOrFail($id);
        $row->update([
            'bpdayactanytime' => $req->get('allow'),
        ]);
        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function setprosact($id, Request $req, BusinessPartner $modelBusinessPartner)
    {
        $row = $modelBusinessPartner->findOrFail($id);
        $row->update([
            'bpprosactanytime' => $req->get('allow'),
        ]);
        return response()->json(['message' => \TextMessages::successEdit]);
    }
}
