<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\Security\Feature;
use App\Models\Security\Permission;
use App\Services\Security\PermissionServices;
use App\Services\Security\MenuServices;
use App\Services\Masters\TypeServices;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DBTypes;

class PermissionController extends Controller
{

    public function role(TypeServices $typeServices)
    {
        $roles = $typeServices->byParentId(find_type()->in([DBTypes::role])->get(DBTypes::role)->getId());

        return datatables()->eloquent($roles)
            ->toJson();
    }

    public function menu(Request $req, MenuServices $menuServices)
    {
        $roleid = $req->get('roleid');
        $roles = $menuServices->allMenuParent($roleid);

        return response()->json($roles);
    }

    public function permission(Request $req, PermissionServices $permissionServices)
    {
        $roleid = $req->get('roleid');
        $menuid = $req->get('menuid');
        $roles = $permissionServices->permission($roleid, $menuid);

        return response()->json($roles);
    }

    /**
     * @param Request $req
     * @param Menu|Relation $modelMenu
     *
     * @return JsonResponse
     * */
    public function store(Request $req, Feature $modelMenu, Permission $modelPermission)
    {
        $insert = collect($req->only($modelMenu->getFillable()))->filter();
        $result = $modelMenu->create($insert->toArray());
        $roles = json_decode($req->get('roles'));
        foreach ($roles as $role) {
            $modelPermission->create([
                'roleid' => $role->typeid,
                'permismenuid' => $result->featmenuid,
                'permisfeatid' => $result->featid,
            ]);
        }


        return response()->json(['message' => \TextMessages::successCreate]);
    }

    /**
     * @param mixed $id
     * @param Permissionervices $Permissionervices
     *
     * @return JsonResponse
     * */
    public function show($id, PermissionServices $Permissionervices)
    {
        $row = $Permissionervices->find($id);
        return response()->json($row);
    }

    /**
     * @param mixed $id
     * @param Request $req
     * @param Menu|Relation $modelMenu
     *
     * @return JsonResponse
     * */
    public function update($id, Request $req, PermissionServices $modelMenu)
    {
        $row = $modelMenu->findOrFail($id);
        $row->update(['hasaccess' => $req->get('hasaccess'), 'updatedby' => $req->get('updatedby')]);

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    /**
     * @param mixed $id
     * @param Menu|Relation $modelMenu
     *
     * @return JsonResponse
     * */
    public function destroy($id, Feature $modelMenu, Permission $modelPermission)
    {
        DB::beginTransaction();
        try {
            $modelPermission->where('permisfeatid', $id)->delete();
            $modelMenu->findOrFail($id)->delete();
            DB::commit();

            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
