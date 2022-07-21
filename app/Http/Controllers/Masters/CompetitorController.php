<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Collections\Files\FileUploader;
use App\Services\Masters\CompetitorServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DBTypes;
use Exception;
use GuzzleHttp\Psr7\MultipartStream;

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
        DB::beginTransaction();
        try {
            $insert = collect($req->only($modelCompetitorServices->getFillable()))->filter()->except('updatedby');

            $competitor = $modelCompetitorServices->create($insert->toArray());
            $pics = $req->file('comptpics');
            var_dump($pics);
            // if ($pics) {
            //     for ($i = $req->get('imagetotal'); $i < -1; $i--) {
            //         $no = 0;
            //         $no++;
            //         $filename = $competitor->comptname . $no;
            //         $transType = find_type()->in([DBTypes::comppics])->get(DBTypes::comppics)->getId();
            //         $file = new FileUploader($pics->$i, $filename, 'images/', $transType, $competitor->comptid);
            //         $competitor  = $competitor && $file->upload() != null;
            //         var_dump($competitor);
            //     }
            // }
            // DB::commit();
            return response()->json(['message' => \TextMessages::successCreate]);
        } catch (Exception $th) {
            DB::rollBack();
        }
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
