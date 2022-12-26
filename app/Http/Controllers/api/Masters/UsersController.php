<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\User;
use App\Models\Masters\UserDetail;
use App\Services\Masters\BpQuotaServices;
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

    public function all(Request $req, UserDetailServices $userDetailServices)
    {
        $whereArr = collect($req->all())->filter();
        $users = $userDetailServices->getAll($whereArr);
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

    public function update($id, Request $req, User $modelUser, UserDetail $modelUserDetail)
    {
        $row = $modelUser->findOrFail($id);
        if ($req->get('userpassword') != '') {
            $update = collect($req->only($modelUser->getFillable()))->filter()->put('userpassword', Hash::make($req->get('userpassword')))
                ->except('createdby');
            $row->update($update->toArray());

            $roles = json_decode($req->get('roles'));
            if ($roles) {
                $modelUserDetail->where('userid', $id)->delete();
                foreach ($roles as $role) {
                    $modelUserDetail->create([
                        'userid' => $id,
                        'userdttypeid' => $role->roleid,
                        'userdtbpid' => $role->bpid,
                    ]);
                }
            }
        } else {
            $update = collect($req->only($modelUser->getFillable()))->filter()
                ->except('createdby', 'userpassword');
            $row->update($update->toArray());

            $roles = json_decode($req->get('roles'));
            if ($roles) {
                $modelUserDetail->where('userid', $id)->delete();
                foreach ($roles as $role) {
                    $modelUserDetail->create([
                        'userid' => $id,
                        'userdttypeid' => $role->roleid,
                        'userdtbpid' => $role->bpid,
                    ]);
                }
            }
        }
        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function attachDevice($id, Request $req, User $modelUser)
    {
        $user = $modelUser->findOrFail($id);
        $user->userdeviceid = $req->get('userdeviceid');
        $user->save();
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
