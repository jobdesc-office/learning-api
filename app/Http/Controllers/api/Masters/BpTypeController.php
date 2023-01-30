<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\StBpTypeServices;
use Illuminate\Http\Request;

class BpTypeController extends Controller
{

   public function byCode(Request $req, StBpTypeServices $typeServices)
   {
      $types = $typeServices->byCodeInSecurity($req->get('typecd'), $req->get('bpid'), $req->get('search'));
      return response()->json($types);
   }

   public function show($id, StBpTypeServices $typeServices)
   {
      $row = $typeServices->find($id);
      return response()->json($row);
   }
}
