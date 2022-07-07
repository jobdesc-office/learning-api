<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\CompetitorServices;
use Illuminate\Http\Request;

class CompetitorController extends Controller
{

    public function all(Request $req, CompetitorServices $competitorService)
    {
        $whereArr = collect($req->all())->filter();
        $competitor = $competitorService->getAll($whereArr);
        return response()->json($competitor);
    }

    public function store(Request $req, CompetitorServices $competitorServices)
    {
        $insert = collect($req->all())->filter()
            ->except('updatedby');

        $competitorServices->fill($insert->toArray())->save();

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, CompetitorServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, CompetitorServices $competitorServices)
    {
        $row = $competitorServices->findOrFail($id);

        $update = collect($req->all())->filter()
            ->except('createdby');
        $row->fill($update->toArray())->save();

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, CompetitorServices $competitorServices)
    {
        $competitorServices->find($id)->delete();
        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
