<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\User;
use App\Models\Masters\UserDetail;
use App\Services\Masters\UserServices;
use App\Services\Masters\TypeServices;
use App\Services\Masters\BusinessPartnerServices;
use App\Services\Masters\UserDetailServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function select(Request $req, TypeServices $typeServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $typeServices->select($searchValue);

        return response()->json($selects);
    }

    public function select2(Request $req, BusinessPartnerServices $businessPartnerService)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $businessPartnerService->select($searchValue);

        return response()->json($selects);
    }

    public function datatables(UserServices $userServices)
    {
        $query = $userServices->datatables();

        // return datatables()->eloquent($query)
        //     ->toJson();
        return datatables()->eloquent($query)
            ->toJson();
    }

    public function all(UserServices $userServices)
    {
        $users = $userServices->all();
        return response()->json($users);
    }

    public function store(Request $req, User $modelUser, UserDetail $modelUserDetail)
    {
        $insert = collect($req->only($modelUser->getFillable()))->filter()->put('userpassword', Hash::make($req->get('userpassword')));

        $resultUser = $modelUser->create($insert->toArray());

        $roles = json_decode($req->get('roles'));
        foreach ($roles as $role) {
            $modelUserDetail->create([
                'userid' => $resultUser->userid,
                'userdttypeid' => $role->roleid,
                'userdtbpid' => $role->bpid,
            ]);
        }

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, UserDetailServices $userDetailServices)
    {
        $row = $userDetailServices->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, User $modelUser)
    {
        $row = $modelUser->findOrFail(Crypt::decrypt($id));

        $update = collect($req->only($modelUser->getFillable()))->filter()->put('userpassword', Hash::make($req->get('userpassword')))
            ->except('updatedby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, User $modelUser, UserDetail $modelUserDetail)
    {
        DB::beginTransaction();
        try {
            $rowDt = $modelUserDetail->select('userid')->where('userid', $id)->delete();
            $row = $modelUser->findOrFail($id)->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
