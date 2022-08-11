<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\ContactPersonServices;
use App\Services\Masters\SubdistrictServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactPersonController extends Controller
{
    public function datatables(Request $req, ContactPersonServices $contactPersonServices)
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
        $query = $contactPersonServices->datatables($order, $orderby, $search);

        return
            datatables()->eloquent($query)
            ->toJson()
            ->getOriginalContent();
    }

    public function all(Request $req, ContactPersonServices $prospectService)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $prospectService->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function massStore(Request $req, ContactPersonServices $modelContactPersonServices)
    {
        $roles = json_decode($req->get('contact'));
        foreach ($roles as $role) {
            $modelContactPersonServices->create([
                'contactname' => $req->get('contactname'),
                'contactcustomerid' => $req->get('contactcustomerid'),
                'contacttypeid' => $role->contacttypeid,
                'contactvalueid' => $role->contactvalueid,
            ]);
        }

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function store(Request $req, ContactPersonServices $modelContactPersonServices)
    {
        $insert = collect($req->only($modelContactPersonServices->getFillable()))->filter()
            ->except('updatedby');

        $modelContactPersonServices->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ContactPersonServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, ContactPersonServices $modelContactPersonServices)
    {
        $row = $modelContactPersonServices->findOrFail($id);

        $update = collect($req->only($modelContactPersonServices->getFillable()))->filter()
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, ContactPersonServices $modelContactPersonServices, SubdistrictServices $subdistrictservice)
    {
        DB::beginTransaction();
        try {
            $modelContactPersonServices->findOrFail($id)->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
