<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\BpCustomerService;
use App\Services\Masters\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BpCustomerController extends Controller
{
    public function datatables(Request $req, BpCustomerService $bpcustomerservice)
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
        $query = $bpcustomerservice->datatables($order, $orderby);

        return datatables()->eloquent($query)
            ->toJson();
    }

    public function all(Request $req, BpCustomerService $bpcustomerservice)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $bpcustomerservice->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, BpCustomerService $modelBpCustomerService)
    {

        $insert = collect($req->all())->filter();

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
