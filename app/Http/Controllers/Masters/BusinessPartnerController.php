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

    public function datatables(BusinessPartnerServices $businessPartnerServices)
    {
        $query = $businessPartnerServices->datatables();

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
