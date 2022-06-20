<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\ProductServices;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function selectwithbp($id, Request $req, ProductServices $productservices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $productservices->selectwithbp($searchValue, $id);

        return response()->json($selects);
    }

    public function select(Request $req, ProductServices $productservices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $productservices->select($searchValue);

        return response()->json($selects);
    }

    public function datatables(Request $req, ProductServices $productservices)
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
        $query = $productservices->datatables($order, $orderby, $search);

        return
            datatables()->eloquent($query)
            ->toJson()
            ->getOriginalContent();
    }

    public function all(Request $req, ProductServices $productservices)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $productservices->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, ProductServices $modelProductServices)
    {
        $insert = collect($req->only($modelProductServices->getFillable()))->filter()->except('updatedby');

        $modelProductServices->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ProductServices $productservices)
    {
        $row = $productservices->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, ProductServices $modelProductServices)
    {
        $row = $modelProductServices->findOrFail($id);

        $update = collect($req->only($modelProductServices->getFillable()))->filter()
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, ProductServices $modelProductServices)
    {
        $row = $modelProductServices->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }

    public function byName(Request $req, ProductServices $modelProductServices)
    {
        $filtered = collect($req->all())->filter();
        $row = $modelProductServices->byName($filtered->get('name'));
        return response()->json($row);
    }
}
