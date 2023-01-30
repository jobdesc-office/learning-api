<?php

namespace App\Http\Controllers\api;

use App\Collections\Users\UserColumn;
use App\Services\AuthServices;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function signin(Request $req, AuthServices $authServices)
    {
        $credentials = $req->only(['username', 'password']);

        $type  = find_type()->byCode([\DBTypes::appaccess])
            ->children(\DBTypes::appaccess);
        $onlyMobile = $type->filter(function ($item) {
            return $item->get('typename') == "Only Mobile";
        });
        $both =  $type->filter(function ($item) {
            return $item->get('typename') == "Web And Mobile";
        });
        $credentials['userappaccess'] = $onlyMobile->first()->getId();
        if (!$token = Auth::claims(['source' => $req->get('source')])->attempt($credentials, true)) {
            $credentials['userappaccess'] = $both->first()->getId();
            if (!$token = Auth::claims(['source' => $req->get('source')])->attempt($credentials, true)) {
                return response()->json(['message' => \TextMessages::failedSignIn], 400);
            }
        }

        $user = new UserColumn($authServices->authQuery()->find(\auth()->id()));
        $user->put('userdetails', collect($user->userDetail()->all())->map(function ($data) {
            return [
                'userdtid' => $data->getId(),
                'usertype' => $data->userType()->toArray(),
                'businesspartner' => $data->businessPartner(),
                'securitygroup' => $data->securitygroup(),
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
