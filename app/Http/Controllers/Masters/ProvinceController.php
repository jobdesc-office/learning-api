<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\ProvinceServices;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{

    public function all(Request $req, ProvinceServices $bpcustomerservice)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $bpcustomerservice->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, ProvinceServices $modelProvinceServices)
    {
        $insert = collect($req->only($modelProvinceServices->getFillable()))->filter();

        $modelProvinceServices->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ProvinceServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, ProvinceServices $modelProvinceServices)
    {
        $row = $modelProvinceServices->findOrFail($id);

        $update = collect($req->only($modelProvinceServices->getFillable()))->filter()
            ->except('updatedby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, ProvinceServices $modelProvinceServices)
    {
        $row = $modelProvinceServices->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }

    public function byName(Request $req, ProvinceServices $modelProvinceServices)
    {
        $filtered = collect($req->all())->filter();
        $row = $modelProvinceServices->byName($filtered->get('name'));
        return response()->json($row);
    }
}
