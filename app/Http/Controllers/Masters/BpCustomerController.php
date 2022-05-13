<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\BpCustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        $insert = collect($req->all())->filter();

        $image = $req->file('sbccstmpic');
        if ($image != null) {
            $filename = Str::random(25) . $image->getClientOriginalName();
            $res = $image->storeAs('public/images', $filename);
            if ($res) {
                $insert->put('sbccstmpic', url('/storage/images/' . $filename));
            }
        }

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
