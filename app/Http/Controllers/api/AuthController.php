<?php

namespace App\Http\Controllers\api;

use App\Collections\Users\UserColumn;
use App\Services\AuthServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function signin(Request $req, AuthServices $authServices)
    {
        $credentials = $req->only(['username', 'password']);

        if (!$token = Auth::attempt($credentials, true))
            return response()->json(['message' => \TextMessages::failedSignIn], 400);

        $user = new UserColumn($authServices->authQuery()->find(\auth()->id()));
        $user->put('userdetails', collect($user->userDetail()->all())->map(function ($data) {
            return [
                'userdtid' => $data->getId(),
                'usertype' => $data->userType()->toArray(),
                'businesspartner' => $data->businessPartner(),
            ];
        })->all());
        if ($user->getId() != null) $user->put('jwt_token', $token);

        return response()->json($user->toArray());
    }

    public function verifyToken()
    {
        return response()->json(['message' => 'OK']);
    }

    public function signOut()
    {
        Auth::logout();
        return response()->json(['message' => 'OK']);
    }
}
