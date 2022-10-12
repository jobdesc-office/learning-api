<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\InformationServices;
use Illuminate\Http\Request;

class InformationController extends Controller
{
   public function getall(Request $request, InformationServices $services)
   {
      return response()->json($services->getMobile());
   }
}
