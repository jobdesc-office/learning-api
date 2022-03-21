<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\User;
use App\Services\Masters\UserServices;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
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

    public function show($id, User $modelUser)
    {
        $row = $modelUser->find($id);
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
