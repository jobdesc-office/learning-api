<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\StbptypeServices;
use DB;
use DBTypes;
use Illuminate\Http\Request;

class StbptypeController extends Controller
{

    public function datatables(Request $req, StbptypeServices $stbptypeServices)
    {
        $typeid = $req->get('typeid');
        $bpid = $req->get('bpid');
        $query = $stbptypeServices->datatables($typeid, $bpid);
        return
            datatables()->eloquent($query)
            ->toJson()
            ->getOriginalContent();
    }

    public function datatablesBySeq(Request $req, StbptypeServices $stbptypeServices)
    {
        $typeid = $req->get('typeid');
        $bpid = $req->get('bpid');
        $query = $stbptypeServices->datatables($typeid, $bpid);
        return
            datatables()->eloquent($query)
            ->toJson()
            ->getOriginalContent();
    }

    public function show($id, StbptypeServices $stbptypeServices)
    {
        $row = $stbptypeServices->find($id);
        return response()->json($row);
    }
}
