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
        $query = $customerService->datatables($order, $orderby, $search);

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
