<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\Security\Menu;
use App\Models\Security\Feature;
use App\Models\Security\Permission;
use App\Services\Security\MenuServices;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $query = $menuServices->datatables($order, $orderby, $search);

        return datatables()->eloquent($query)
            ->toJson();
    }

    /**
     * @param Request $req
     * @param Menu|Relation $modelMenu
     *
     * @return JsonResponse
     * */
    public function store(Request $req, Menu $modelMenu, Feature $modelFeature, Permission $modelPermission)
    {
        $insert = collect($req->only($modelMenu->getFillable()))->filter();
        $result = $modelMenu->create($insert->toArray());

        $cruds = json_decode($req->get('crud'));
        $roles = json_decode($req->get('roles'));
        if ($cruds != null) {
            DB::beginTransaction();
            try {
                foreach ($cruds as $crud) {
                    $resultFeature = $modelFeature->create([
                        'featmenuid' => $result->menuid,
                        'feattitle' => $crud->feattitle,
                        'featslug' => $crud->featslug,
                        'featuredesc' => $crud->featuredesc,
                        'createdby' => $result->createdby,
                        'isactive' => $result->isactive,
                    ]);
                    foreach ($roles as $role) {
                        $modelPermission->create([
                            'roleid' => $role->typeid,
                            'permismenuid' => $result->menuid,
                            'permisfeatid' => $resultFeature->featid,
                        ]);
                    }
                }
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(['message' => $th]);
            }
        }

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
    public function destroy($id, Menu $modelMenu, Feature $modelFeature, Permission $modelPermission)
    {
        DB::beginTransaction();
        try {
            $modelFeature->where('featmenuid', $id)->delete();
            $modelPermission->where('permismenuid', $id)->delete();
            $modelMenu->findOrFail($id)->delete();
            DB::commit();

            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
