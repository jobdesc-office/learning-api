<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\DspByCust;
use App\Services\Masters\BpQuotaServices;
use App\Services\Masters\ProspectProductServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProspectProductController extends Controller
{

    public function all(Request $req, ProspectProductServices $prospectProduct)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $prospectProduct->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, ProspectProductServices $modelProspectProductServices, BpQuotaServices $quotaServices)
    {

        if (!$quotaServices->isAllowAddProduct(1)) return response()->json(['message' => "Product " . \TextMessages::limitReached], 400);
        $insert = collect($req->all())->filter()
            ->except('updatedby');
        $modelProspectProductServices->createProspectProduct($insert);

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ProspectProductServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, ProspectProductServices $modelProspectProductServices)
    {
        $update = collect($req->all())->filter()
            ->except('createdby');
        $modelProspectProductServices->updateProspectProduct($id, $update);

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, ProspectProductServices $modelProspectProductServices)
    {
        $modelProspectProductServices->find($id)->delete();
        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
