<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\Security\Feature;
use App\Models\Security\Menu;
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

    public function updateParentAccess(Request $req, PermissionServices $modelMenu)
    {
        $parent = $modelMenu->where('roleid', $req->get('roleid'))->where('permisfeatid', $req->get('parentId'))->update(['hasaccess' => $req->get('hasaccess'), 'updatedby' => $req->get('updatedby')]);
        $childId = $req->get('childId');
        foreach ($childId as $c) {
            $child = $modelMenu->where('roleid', $req->get('roleid'))->where('permisfeatid', $c)->update(['hasaccess' => $req->get('hasaccess'), 'updatedby' => $req->get('updatedby')]);
        }
        $data = [$parent, $child];

        return response($data);
    }

    public function permission(Request $req, MenuServices $menuServices)
    {
        $roleid = $req->get('roleid');
        $roles = $menuServices->permission($roleid);

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
    public function update(int $id, Request $req, PermissionServices $modelMenu)
    {
        $row = $modelMenu->where('roleid', $req->get('roleid'))->where('permisid', $id)->update(['hasaccess' => $req->get('hasaccess'), 'updatedby' => $req->get('updatedby')]);
        $childId = $req->get('childId');
        $childValue = [];
        $index = 0;
        foreach ($childId as $c) {
            $childValue[$index] = $modelMenu->select('hasaccess')->where('roleid', $req->get('roleid'))->where('permisfeatid', $c)->get();
            $index++;
        }

        if (($childValue[0][0]['hasaccess'] == 1 && $childValue[1][0]['hasaccess'] == 1) || (($childValue[0][0]['hasaccess'] == 0 && $childValue[1][0]['hasaccess'] == 1) || ($childValue[0][0]['hasaccess'] == 1 && $childValue[1][0]['hasaccess'] == 0))) {
            $parent = $modelMenu->where('roleid', $req->get('roleid'))->where('permisfeatid', $req->get('parentId'))->update(['hasaccess' => 'true', 'updatedby' => $req->get('updatedby')]);
        } else if ($childValue[0][0]['hasaccess'] == 0 && $childValue[1][0]['hasaccess'] == 0) {
            $parent = $modelMenu->where('roleid', $req->get('roleid'))->where('permisfeatid', $req->get('parentId'))->update(['hasaccess' => 'false', 'updatedby' => $req->get('updatedby')]);
        }

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
