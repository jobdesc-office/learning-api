<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\User;
use App\Models\Masters\UserDetail;
use App\Services\Masters\UserServices;
use App\Services\Masters\TypeServices;
use App\Services\Masters\BusinessPartnerServices;
use App\Services\Masters\UserDetailServices;
use Hamcrest\Type\IsInteger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{

    public function prospectowner(Request $req, UserDetailServices $userDetailServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $userDetailServices->prospectowner($searchValue);

        return response()->json($selects);
    }

    public function select(Request $req, UserServices $userServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $userServices->select($searchValue);

        return response()->json($selects);
    }

    public function allUser(Request $req, UserServices $userServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $query = $userServices->allUser($searchValue);

        return response()->json($query);
    }

    public function datatables(UserServices $userServices)
    {
        $query = $userServices->datatables();

        return
            datatables()->eloquent($query)
            ->toJson()
            ->getOriginalContent();
    }

    public function all(Request $req, UserDetailServices $userDetailServices)
    {
        $whereArr = collect($req->all())->filter();
        $users = $userDetailServices->getAll($whereArr);
        return response()->json($users);
    }

    public function store(Request $req, User $modelUser, UserDetail $modelUserDetail)
    {
        $insert = collect($req->only($modelUser->getFillable()))->filter()->put('userpassword', Hash::make($req->get('userpassword')))->except('updatedby');

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

    public function update($id, Request $req, User $modelUser, UserDetail $modelUserDetail)
    {
        $row = $modelUser->findOrFail($id);

        $update = collect($req->only($modelUser->getFillable()))->filter()->put('userpassword', Hash::make($req->get('userpassword')))
            ->except('createdby');
        $row->update($update->toArray());

        $dt = $modelUserDetail->findOrFail($id);
        $roles = json_decode($req->get('roles'));
        foreach ($roles as $role) {
            $dt->update([
                'userdttypeid' => $role->roleid,
                'userdtbpid' => $role->bpid,
            ]);
        }
        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, User $modelUser, UserDetail $modelUserDetail)
    {
        DB::beginTransaction();
        try {
            $modelUserDetail->select('userid')->where('userid', $id)->delete();
            $modelUser->findOrFail($id)->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
