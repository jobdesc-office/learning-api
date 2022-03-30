<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\User;
use App\Services\Masters\UserServices;
use App\Services\Masters\TypeServices;
use App\Services\Masters\BusinessPartnerServices;
use App\Services\Masters\UserDetailServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        return datatables()->eloquent($query)
            ->toJson();
    }

    public function store(Request $req, User $modelUser)
    {
        $insert = collect($req->only($modelUser->getFillable()))->filter()->put('userpassword', Hash::make($req->get('userpassword')));

        $modelUser->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, UserServices $userServices)
    {
        $row = $userServices->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, User $modelUser)
    {
        $row = $modelUser->findOrFail($id);

        $update = collect($req->only($modelUser->getFillable()))->filter()->put('userpassword', Hash::make($req->get('userpassword')))
        ->except('updatedby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, User $modelUser)
    {
        $row = $modelUser->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
