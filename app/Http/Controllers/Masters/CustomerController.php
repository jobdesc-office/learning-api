<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function select(Request $req, CustomerService $customerService)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $customerService->select($searchValue);

        return response()->json($selects);
    }

    public function datatables(Request $req, CustomerService $customerService)
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
        $query = $customerService->datatables($order, $orderby);

        return datatables()->eloquent($query)
            ->toJson();
    }

    public function all(Request $req, CustomerService $customerService)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $customerService->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, CustomerService $modelCustomerService)
    {
        $insert = collect($req->only($modelCustomerService->getFillable()))->filter()->except('updatedby');

        $modelCustomerService->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, CustomerService $customerService)
    {
        $row = $customerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, CustomerService $modelCustomerService)
    {
        $row = $modelCustomerService->findOrFail($id);

        $update = collect($req->only($modelCustomerService->getFillable()))->filter()
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, CustomerService $modelCustomerService)
    {
        $row = $modelCustomerService->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
