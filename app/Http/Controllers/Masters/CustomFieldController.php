<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\CustomFieldService;
use Illuminate\Http\Request;

class CustomFieldController extends Controller
{

    public function selectBp($id, Request $req, CustomFieldService $CustomFieldService)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $CustomFieldService->selectBp($searchValue, $id);

        return response()->json($selects);
    }

    public function WithBp($id, CustomFieldService $CustomFieldService)
    {
        $selects = $CustomFieldService->withBp($id);

        return response()->json($selects);
    }


    public function selectWithBp($id, Request $req, CustomFieldService $CustomFieldService)
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
        $query = $CustomFieldService->selectWithBp($order, $orderby, $search, $id);

        return datatables()->eloquent($query)
            ->toJson();
    }

    public function select(Request $req, CustomFieldService $CustomFieldService)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $CustomFieldService->select($searchValue);

        return response()->json($selects);
    }

    public function datatables(Request $req, CustomFieldService $CustomFieldService)
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
        $query = $CustomFieldService->datatables($order, $orderby, $search);

        return datatables()->eloquent($query)
            ->toJson();
    }

    public function all(Request $req, CustomFieldService $CustomFieldService)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $CustomFieldService->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, CustomFieldService $modelCustomFieldService)
    {
        $insert = collect($req->only($modelCustomFieldService->getFillable()))->filter()->except('updatedby');

        $modelCustomFieldService->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, CustomFieldService $CustomFieldService)
    {
        $row = $CustomFieldService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, CustomFieldService $modelCustomFieldService)
    {
        $row = $modelCustomFieldService->findOrFail($id);

        $update = collect($req->only($modelCustomFieldService->getFillable()))->filter()
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, CustomFieldService $modelCustomFieldService)
    {
        $row = $modelCustomFieldService->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
