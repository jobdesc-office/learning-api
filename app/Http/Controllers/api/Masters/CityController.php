<?php

namespace App\Http\Controllers\api\masters;

use App\Collections\Files\FileFinder;
use App\Http\Controllers\Controller;
use App\Services\Masters\CityServices;
use App\Services\Masters\SubdistrictServices;
use App\Collections\Files\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CityController extends Controller
{

    public function all(Request $req, CityServices $bpcustomerservice)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $bpcustomerservice->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, CityServices $modelCityServices)
    {
        $insert = collect($req->only($modelCityServices->getFillable()))->filter()
            ->except('updatedby');

        $modelCityServices->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, CityServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, CityServices $modelCityServices)
    {
        $row = $modelCityServices->findOrFail($id);

        $update = collect($req->only($modelCityServices->getFillable()))->filter()
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, CityServices $modelCityServices, SubdistrictServices $subdistrictservice)
    {
        DB::beginTransaction();
        try {
            $subdistrictservice->select('subdistrictcityid')->where('subdistrictcityid', $id)->delete();
            $modelCityServices->findOrFail($id)->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function byName(Request $req, CityServices $modelCityServices)
    {
        $filtered = collect($req->all())->filter();
        $row = $modelCityServices->byName($filtered->get('name'));
        return response()->json($row);
    }
}
