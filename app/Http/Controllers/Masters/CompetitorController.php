<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\CompetitorServices;
use Illuminate\Http\Request;

class CompetitorController extends Controller
{

    public function select(Request $req, CompetitorServices $CompetitorServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $CompetitorServices->select($searchValue);

        return response()->json($selects);
    }

    public function datatables(Request $req, CompetitorServices $CompetitorServices)
    {
        $search = trim(strtolower($req->get('search[value]')));
        $order = $req->get('order[0][column]');
        $orderby = $req->get('order[0][dir]');

        switch ($order) {
            case 0:
                $order = $req->get('columns[0][data]');
                break;
            case 1:
                $order = $req->get('columns[1][data]');
                break;
            case 2:
                $order = $req->get('columns[2][data]');
                break;

            case 3:
                $order = $req->get('columns[3][data]');
                break;

            case 4:
                $order = $req->get('columns[4][data]');
                break;

            case 5:
                $order = $req->get('columns[5][data]');
                break;

            case 6:
                $order = $req->get('columns[6][data]');
                break;

            case 7:
                $order = $req->get('columns[7][data]');
                break;

            case 8:
                $order = $req->get('columns[8][data]');
                break;

            case 9:
                $order = $req->get('columns[9][data]');
                break;

            default:
                $order = $order;
                break;
        }
        $query = $CompetitorServices->datatables($order, $orderby, $search);

        return datatables()->eloquent($query)
            ->toJson();
    }

    public function all(Request $req, CompetitorServices $CompetitorServices)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $CompetitorServices->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, CompetitorServices $modelCompetitorServices)
    {
        $insert = collect($req->only($modelCompetitorServices->getFillable()))->filter()->except('updatedby');

        $modelCompetitorServices->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, CompetitorServices $CompetitorServices)
    {
        $row = $CompetitorServices->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, CompetitorServices $modelCompetitorServices)
    {
        $row = $modelCompetitorServices->findOrFail($id);

        $update = collect($req->only($modelCompetitorServices->getFillable()))->filter()
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, CompetitorServices $modelCompetitorServices)
    {
        $row = $modelCompetitorServices->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
