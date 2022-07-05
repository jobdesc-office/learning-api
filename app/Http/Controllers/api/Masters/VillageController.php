<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\VillageServices;
use App\Services\Masters\SubdistrictServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VillageController extends Controller
{

    public function all(Request $req, VillageServices $villageServices)
    {
        $whereArr = collect($req->all())->filter();
        $villages = $villageServices->getAll($whereArr);
        return response()->json($villages);
    }

    public function store(Request $req, VillageServices $villageServices)
    {
        $insert = collect($req->only($villageServices->getFillable()))->filter()
            ->except('updatedby');

        $villageServices->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, VillageServices $villageServices)
    {
        $row = $villageServices->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, VillageServices $villageServices)
    {
        $row = $villageServices->findOrFail($id);

        $update = collect($req->only($villageServices->getFillable()))->filter()
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, VillageServices $villageServices)
    {
        $row = $villageServices->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }

    public function byName(Request $req, VillageServices $modelVillageServices)
    {
        $filtered = collect($req->all())->filter();
        $row = $modelVillageServices->placesByName($filtered);
        return response()->json($row);
    }
}
