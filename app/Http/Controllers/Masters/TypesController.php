<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\TypeServices;
use Illuminate\Http\Request;

class TypesController extends Controller
{

    public function byCode(Request $req, TypeServices $typeServices)
    {
        $types = $typeServices->byCode($req->get('typecd'));
        return response()->json($types);
    }

    public function datatables(TypeServices $typeServices)
    {
        $query = $typeServices->datatables();

        return datatables()->eloquent($query)
            ->toJson();
    }
}
