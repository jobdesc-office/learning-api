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

    public function datatables(MenuServices $menuServices)
    {
        $query = $menuServices->datatables();

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
