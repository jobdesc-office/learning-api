<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\Security\Feature;
use App\Models\Security\Permission;
use App\Services\Security\FeatureServices;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeaturesController extends Controller
{

    public function datatables($id, Request $req, FeatureServices $FeatureServices)
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
        $query = $FeatureServices->datatables($id, $order, $orderby, $search);

        return datatables()->eloquent($query)
            ->toJson();
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
     * @param FeatureServices $FeatureServices
     *
     * @return JsonResponse
     * */
    public function show($id, FeatureServices $FeatureServices)
    {
        $row = $FeatureServices->find($id);
        return response()->json($row);
    }

    /**
     * @param mixed $id
     * @param Request $req
     * @param Menu|Relation $modelMenu
     *
     * @return JsonResponse
     * */
    public function update($id, Request $req, Feature $modelMenu)
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
