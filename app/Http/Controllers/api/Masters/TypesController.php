<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\TypeServices;
use Illuminate\Http\Request;

class TypesController extends Controller
{

    public function byCode(Request $req, TypeServices $typeServices)
    {
        $types = $typeServices->byCode($req->get('typecd'), $req->get('search'));
        return response()->json($types);
    }

    public function show($id, TypeServices $typeServices)
    {
        $row = $typeServices->find($id);
        return response()->json($row);
    }
}
