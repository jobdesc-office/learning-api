<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\SubdistrictServices;
use Illuminate\Http\Request;

class SubdistrictController extends Controller
{
    public function datatables(SubdistrictServices $subdistrictservice)
    {
        $query = $subdistrictservice->datatables();

        return
            datatables()->eloquent($query)
            ->toJson()
            ->getOriginalContent();
    }

    public function all(Request $req, SubdistrictServices $bpcustomerservice)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $bpcustomerservice->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, SubdistrictServices $modelSubdistrictServices)
    {
        $insert = collect($req->only($modelSubdistrictServices->getFillable()))->filter()->except('updatedby');

        $modelSubdistrictServices->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, SubdistrictServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, SubdistrictServices $modelSubdistrictServices)
    {
        $row = $modelSubdistrictServices->findOrFail($id);

        $update = collect($req->only($modelSubdistrictServices->getFillable()))->filter()
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, SubdistrictServices $modelSubdistrictServices)
    {
        $row = $modelSubdistrictServices->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }

    public function byName(Request $req, SubdistrictServices $modelSubdistrictServices)
    {
        $filtered = collect($req->all())->filter();
        $row = $modelSubdistrictServices->byName($filtered->get('name'));
        return response()->json($row);
    }
}
