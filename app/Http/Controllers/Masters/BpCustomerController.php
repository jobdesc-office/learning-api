<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\BpCustomerService;
use App\Services\Masters\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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

        $insert = collect($req->all())->filter()->except('updatedby');

        $result = $modelBpCustomerService->createCustomer($insert);

        if ($result) {
            return response()->json(['message' => \TextMessages::successCreate,]);
        } else {
            return response()->json(['message' => \TextMessages::failedCreate,], 400);
        }
    }

    public function show($id, BpCustomerService $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, BpCustomerService $modelBpCustomerService)
    {
        $bpCustomer = $modelBpCustomerService->findOrFail($id);
        $insert = collect($req->all())->filter()->except('createdby');

        $image = $req->file('sbccstmpic');
        if ($image != null) {
            $filename = explode('/', $bpCustomer->sbccstmpic);
            $filename = end($filename);
            $res = $image->storeAs('public/images', $filename);
            if ($res) {
                $insert->put('sbccstmpic', url('/storage/images/' . $filename));
            }
        }

        $resultCustomer = $modelBpCustomerService->updateCustomer($id, $insert);

        if ($resultCustomer) {
            return response()->json(['message' => \TextMessages::successEdit,]);
        } else {
            return response()->json(['message' => \TextMessages::failedEdit,], 400);
        }
    }

    public function destroy($id, BpCustomerService $modelBpCustomerService)
    {
        $row = $modelBpCustomerService->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
