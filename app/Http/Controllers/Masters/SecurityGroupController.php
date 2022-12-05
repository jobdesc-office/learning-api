<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\SecurityGroupServices;
use App\Models\Masters\SecurityGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DBTypes;

class SecurityGroupController extends Controller
{

    public function byCodeMaster(Request $req, SecurityGroupServices $securityGroupService)
    {
        $types = $securityGroupService->byCodeMaster($req->get('sgcode'));
        return response($types);
    }

    public function byCodeAdd(Request $req, SecurityGroupServices $securityGroupService)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $masterid = $securityGroupService->byCodes($req->get('sgcode'));
        $types = $securityGroupService->byCodeAdd($req->get('sgcode'), $searchValue);
        return response()->json($types, 200, ['searchValue' => $searchValue, 'masterid' => json_encode($masterid)]);
    }

    public function byCode(Request $req, SecurityGroupServices $securityGroupService)
    {
        $types = $securityGroupService->byCode($req->get('sgcode'));
        return response()->json($types);
    }

    public function datatables(Request $req, SecurityGroupServices $securityGroupService)
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
        $query = $securityGroupService->datatables($order, $orderby, $search, $req->get('sgbpid'), $req->get('sgmasterid'));
        // dd($query->toSql());
        return
            datatables()->eloquent($query)
            ->toJson()
            ->getOriginalContent();
    }

    public function store(Request $req, SecurityGroup $modelSecurityGroup)
    {
        $insert = collect($req->only($modelSecurityGroup->getFillable()))->filter()->except('updatedby');

        $modelSecurityGroup->fill($insert->toArray())->save();

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, SecurityGroupServices $securityGroupService)
    {
        $row = $securityGroupService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, SecurityGroup $modelSecurityGroup)
    {
        $row = $modelSecurityGroup->findOrFail($id);

        $update = collect($req->only($modelSecurityGroup->getFillable()))
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, SecurityGroup $modelSecurityGroup)
    {
        DB::beginTransaction();
        try {
            $modelSecurityGroup->select('sgid')->where('sgmasterid', $id)->delete();
            $modelSecurityGroup->findOrFail($id)->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
