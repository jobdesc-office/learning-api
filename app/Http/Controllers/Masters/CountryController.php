<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\CountryServices;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    public function select(Request $req, CountryServices $countryservice)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $countryservice->select($searchValue);

        return response()->json($selects);
    }

    public function datatables(Request $req, CountryServices $countryservice)
    {
        $query = $countryservice->datatables();

        return
            datatables()->eloquent($query)
            ->toJson()
            ->getOriginalContent();
    }

    public function all(Request $req, CountryServices $bpcustomerservice)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $bpcustomerservice->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, CountryServices $modelCountryServices)
    {
        $insert = collect($req->only($modelCountryServices->getFillable()))->filter()->except('updatedby');

        $modelCountryServices->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, CountryServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, CountryServices $modelCountryServices)
    {
        $row = $modelCountryServices->findOrFail($id);

        $update = collect($req->only($modelCountryServices->getFillable()))->filter()
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, CountryServices $modelCountryServices)
    {
        $row = $modelCountryServices->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }

    public function byName(Request $req, CountryServices $modelCountryServices)
    {
        $filtered = collect($req->all())->filter();
        $row = $modelCountryServices->byName($filtered->get('name'));
        return response()->json($row);
    }
}
