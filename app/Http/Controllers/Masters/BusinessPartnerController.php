<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\BusinessPartner;
use App\Services\Masters\BusinessPartnerServices;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BusinessPartnerController extends Controller
{
    public function datatables(BusinessPartnerServices $businessPartnerServices)
    {
        $query = $businessPartnerServices->datatables();

        return datatables()->eloquent($query)
            ->toJson();
    }

    public function store(Request $req, BusinessPartner $modelBusinessPartner)
    {
        $insert = collect($req->only($modelBusinessPartner->getFillable()))->filter();

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
        ->except('updatedby');
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
