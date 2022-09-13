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
            response()->json($query);
    }

    public function datatablesBySeq(Request $req, StbptypeServices $stbptypeServices)
    {
        $typeid = $req->get('typeid');
        $bpid = $req->get('bpid');
        $query = $stbptypeServices->datatablesBySeq($typeid, $bpid);
        return response()->json($query);
    }

    public function show($id, StbptypeServices $stbptypeServices)
    {
        $row = $stbptypeServices->find($id);
        return response()->json($row);
    }

    public function store(Request $req, StbptypeServices $stbptypeServices)
    {
        $insert = collect($req->only($stbptypeServices->getFillable()))->filter()->except('updatedby');

        $stbptypeServices->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function update($id, Request $req, StbptypeServices $stbptypeServices)
    {
        $row = $stbptypeServices->findOrFail($id);

        $update = collect($req->only($stbptypeServices->getFillable()))
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, StbptypeServices $stbptypeServices)
    {
        $row = $stbptypeServices->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
