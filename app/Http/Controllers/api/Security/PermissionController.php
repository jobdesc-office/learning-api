<?php

namespace App\Http\Controllers\api\Security;

use App\Http\Controllers\Controller;
use App\Services\Security\MenuServices;
use App\Services\Masters\UserDetailServices;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

   public function permissions($id, Request $req, UserDetailServices $userDetailServices,  MenuServices $menuServices)
   {
      $userDetail = $userDetailServices->find($id);
      $roles = $menuServices->permissionApp($userDetail->userdttypeid);
      return response()->json($roles);
   }
}
