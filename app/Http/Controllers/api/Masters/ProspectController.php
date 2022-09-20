<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\DspByCust;
use App\Models\Masters\Prospect;
use App\Models\Masters\ProspectCustomField;
use App\Services\Masters\CustomFieldService;
use App\Services\Masters\DspByCustServices;
use App\Services\Masters\ProspectAssignServices;
use App\Services\Masters\ProspectActivityServices;
use App\Services\Masters\ProspectCustomFieldServices;
use App\Services\Masters\ProspectProductServices;
use App\Services\Masters\ProspectServices;
use App\Services\Masters\TrHistoryServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProspectController extends Controller
{

    public function all(Request $req, ProspectServices $prospectService)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $prospectService->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, ProspectServices $modelProspectServices)
    {
        $insert = collect($req->all())->filter()->except('updatedby');
        $insert->put('prospectcode', $modelProspectServices->generateCode());
        $insert->put('createdby',  auth()->user()->userid);
        $modelProspectServices->fill($insert->toArray())->save();

        if ($insert->has('products')) {
            foreach ($insert->get('products') as $product) {
                $productData = collect($product);
                $productData->put('prosproductprospectid', $modelProspectServices->prospectid);

                $prospectProductServices = new ProspectProductServices();
                $prospectProductServices->createProspectProduct($productData);
            }
        }

        if ($insert->has('customfields')) {
            foreach ($insert->get('customfields') as $customField) {
                $customFieldData = collect($customField);
                $customFieldData->put('prospectid', $modelProspectServices->prospectid);

                $customFieldModel = new ProspectCustomField();
                $customFieldModel->fill($customFieldData->toArray());
                $customFieldModel->save();
            }
        }

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ProspectServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, ProspectServices $modelProspectServices)
    {
        $row = $modelProspectServices->findOrFail($id);

        $update = collect($req->only($modelProspectServices->getFillable()))->filter()
            ->except('createdby');
        $update->put('updatedby',  auth()->user()->userid);
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, ProspectServices $modelProspectServices, ProspectActivityServices $modelProspectActivity, ProspectProductServices $modelProspectProduct, ProspectAssignServices $modelProspectAssign)
    {
        DB::beginTransaction();
        try {
            $modelProspectAssign->where('prospectid', $id)->delete();
            $modelProspectProduct->where('prosproductprospectid', $id)->delete();
            $modelProspectActivity->where('prospectdtprospectid', $id)->delete();
            $modelProspectServices->findOrFail($id)->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    public function prospectCount(Request $req, ProspectServices $prospectServices)
    {
        $prospects = $prospectServices->countAll(collect($req->all()));
        return response()->json(['count' => $prospects]);
    }

    public function prospectHistories(Request $request, TrHistoryServices $trHistoryServices, Prospect $prospect)
    {
        return $trHistoryServices->findHistories($request->get('prospectid'), $prospect->getTable(), $request->get('bpid'));
    }

    public function prospectcustomfield($id, CustomFieldService $service)
    {
        $customField = $service->byBp($id);
        return response()->json($customField);
    }
}
