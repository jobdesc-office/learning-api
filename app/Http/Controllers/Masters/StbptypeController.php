<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\StbptypeServices;
use DB;
use DBTypes;
use Illuminate\Http\Request;

class StbptypeController extends Controller
{

    public function byCode(Request $req, StbptypeServices $stbptypeServices)
    {
        $bpid = $req->get('bpid');
        $types = $stbptypeServices->byCode($req->get('typecd'), $bpid);
        return response()->json($types);
    }

    public function byCodeAdd(Request $req, StbptypeServices $typeServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $masterid = find_type()->in([$req->get('typecd')])->get($req->get('typecd'))->getId();
        $master = find_type()->in([$req->get('typecd')])->get($req->get('typecd'))->getName();
        $bpid = $req->get('bpid');
        $types = $typeServices->byCodeAdd($req->get('typecd'), $bpid, $searchValue);
        return response()->json($types, 200, ['searchValue' => $searchValue, 'masterid' => json_encode($masterid), 'master' => json_encode($master)]);
    }

    public function bySeq(Request $req, StbptypeServices $stbptypeServices)
    {
        $bpid = $req->get('bpid');
        $types = $stbptypeServices->bySeq($req->get('typecd'), $bpid);
        return response()->json($types);
    }

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
