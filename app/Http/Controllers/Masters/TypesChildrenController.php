<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\TypeChildrenServices;
use Illuminate\Http\Request;

class TypesChildrenController extends Controller
{
    public function datatables($id, TypeChildrenServices $typeChildrenServices)
    {
        $query = $typeChildrenServices->datatables($id);

        return datatables()->eloquent($query)
            ->toJson();
    }

    public function parent(TypeChildrenServices $typeChildrenServices)
    {
        $query = $typeChildrenServices->parent();

        return response()->json($query);
    }

    public function datatabless(TypeChildrenServices $typeChildrenServices)
    {
        $query = $typeChildrenServices->datatabless();

        return datatables()->eloquent($query)
            ->toJson();
    }
}
