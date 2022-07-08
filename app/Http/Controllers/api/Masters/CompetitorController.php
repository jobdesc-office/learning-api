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

        if ($req->hasFile('comptpics')) {
            $insert->put('comptpics', $req->file('comptpics'));
        }

        $competitorServices->store($insert);

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, CompetitorServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, CompetitorServices $competitorServices)
    {
        $update = collect($req->all())->filter()
            ->except('createdby');
        if ($req->hasFile('comptpics')) {
            $update->put('comptpics', $req->file('comptpics'));
        }

        $competitorServices->edit($id, $update);

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, CompetitorServices $competitorServices)
    {
        $competitorServices->find($id)->delete();
        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
