<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\Security\Menu;
use App\Services\Security\MenuServices;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenusController extends Controller
{

    public function select(Request $req, MenuServices $menuServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $menuServices->select($searchValue);

        return response()->json($selects);
    }

    public function datatables(Request $req, MenuServices $menuServices)
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
        $query = $menuServices->datatables($order, $orderby);

        return datatables()->eloquent($query)
            ->toJson();
    }

    /**
     * @param Request $req
     * @param Menu|Relation $modelMenu
     *
     * @return JsonResponse
     * */
    public function store(Request $req, Menu $modelMenu)
    {
        $insert = collect($req->only($modelMenu->getFillable()))->filter();
        $modelMenu->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    /**
     * @param mixed $id
     * @param MenuServices $menuServices
     *
     * @return JsonResponse
     * */
    public function show($id, MenuServices $menuServices)
    {
        $row = $menuServices->find($id);
        return response()->json($row);
    }

    /**
     * @param mixed $id
     * @param Request $req
     * @param Menu|Relation $modelMenu
     *
     * @return JsonResponse
     * */
    public function update($id, Request $req, Menu $modelMenu)
    {
        $row = $modelMenu->findOrFail($id);

        $update = collect($req->only($modelMenu->getFillable()))->filter()
            ->except('updatedby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    /**
     * @param mixed $id
     * @param Menu|Relation $modelMenu
     *
     * @return JsonResponse
     * */
    public function destroy($id, Menu $modelMenu)
    {
        $row = $modelMenu->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
