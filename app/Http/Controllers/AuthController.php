<?php

namespace App\Http\Controllers;

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

        if (!$token = Auth::claims(['source' => $req->get('source')])->attempt($credentials, true))
            return response()->json(['message' => \TextMessages::failedSignIn], 400);

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
                    'securitygroup' => $data->securitygroup(),
                ];
            })->all(),
        ]);
        if ($user->getId() != null) $response->put('jwt_token', $token);

        return response()->json($response);
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
