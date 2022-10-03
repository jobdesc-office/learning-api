<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\ContactPersonServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactPersonController extends Controller
{
    public function all(Request $req, ContactPersonServices $prospectService)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $prospectService->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, ContactPersonServices $modelContactPersonServices)
    {
        $insert = collect($req->only($modelContactPersonServices->getFillable()))->filter()
            ->except('updatedby');

        $modelContactPersonServices->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ContactPersonServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, ContactPersonServices $modelContactPersonServices)
    {
        $row = $modelContactPersonServices->findOrFail($id);

        $update = collect($req->only($modelContactPersonServices->getFillable()))->filter()
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, ContactPersonServices $modelContactPersonServices)
    {
        $modelContactPersonServices->find($id)->delete();
        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
