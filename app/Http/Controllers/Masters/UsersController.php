<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Collections\Users\UserColumn;
use App\Models\Masters\User;
use App\Models\Masters\UserDetail;
use App\Services\Masters\UserServices;
use App\Services\Masters\TypeServices;
use App\Services\Masters\BusinessPartnerServices;
use App\Services\Masters\UserDetailServices;
use App\Services\AuthServices;
use Hamcrest\Type\IsInteger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function session(AuthServices $authServices)
    {
        $user = new UserColumn($authServices->authQuery()->find(\auth()->id()));
        $response = collect([
            'userid' => $user->getId(),
            'userfullname' => $user->getFullName(),
            'username' => $user->getName(),
            'useremail' => $user->getEmail(),
            'userphone' => $user->getPhone(),
            'userdetails' => collect($user->userDetail()->all())->map(function ($data) {
                return [
                    'userdtid' => $data->getId(),
                    'usertype' => $data->userType()->toArray(),
                    'businesspartner' => $data->businessPartner()->toArray(),
                ];
            })->all(),
        ]);

        return response()->json($response);
    }

    public function prospectowner(Request $req, UserDetailServices $userDetailServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $userDetailServices->prospectowner($searchValue);

        return response()->json($selects);
    }

    public function reset($id, UserServices $userServices)
    {
        $userServices->findOrFail($id)->update([
            'userdeviceid' => '',
        ]);

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function select(Request $req, UserServices $userServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $userServices->select($searchValue);

        return response()->json($selects);
    }

    public function selectwithsamebp($id, Request $req, UserServices $userServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $userServices->selectwithsamebp($searchValue, $id);

        return response()->json($selects);
    }

    public function allUser(Request $req, UserServices $userServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $query = $userServices->allUser($searchValue);

        return response()->json($query);
    }

    public function datatables(Request $req, UserServices $userServices)
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
        $query = $userServices->datatables($order, $orderby, $search);
        return
            datatables()->eloquent($query)
            ->toJson()
            ->getOriginalContent();
    }

    public function datatablesbp($id, Request $req, UserServices $userServices)
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
        $query = $userServices->datatablesbp($id, $order, $orderby, $search);
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

    public function show($id, UserServices $userServices)
    {
        $row = $userServices->find($id);
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
