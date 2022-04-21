<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\BpCustomerService;
use Illuminate\Http\Request;

class BpCustomerController extends Controller
{

    public function all(Request $req, BpCustomerService $bpcustomerservice)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $bpcustomerservice->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, BpCustomerService $modelBpCustomerService)
    {
        $insert = collect($req->only($modelBpCustomerService->getFillable()))->filter();

        $modelBpCustomerService->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, BpCustomerService $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, BpCustomerService $modelBpCustomerService)
    {
        $row = $modelBpCustomerService->findOrFail($id);

        $update = collect($req->only($modelBpCustomerService->getFillable()))->filter()
            ->except('updatedby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, BpCustomerService $modelBpCustomerService)
    {
        $row = $modelBpCustomerService->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
