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

    public function datatables(CustomerService $customerService)
    {
        $query = $customerService->datatables();

        return
            datatables()->eloquent($query)
            ->toJson()
            ->getOriginalContent();
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
