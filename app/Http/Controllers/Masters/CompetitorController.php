<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Collections\Files\FileUploader;
use App\Collections\Files\FileFinder;
use App\Services\Masters\CompetitorServices;
use App\Models\Masters\Files;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DBTypes;
use Exception;

class CompetitorController extends Controller
{

    public function deleteImages(Request $req, Files $modelFiles)
    {
        $transtypeid = $req->get('transtypeid');
        $refid = $req->get('refid');
        DB::beginTransaction();
        try {
            $files = $modelFiles->where('refid', $refid)->where('transtypeid', $transtypeid)->get();
            foreach ($files as $key) {
                $modelFiles->findOrFail($key->fileid)->delete();
            }
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th]);
        }
    }

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

    public function datatablesbp($id, Request $req, CompetitorServices $CompetitorServices)
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
        $query = $CompetitorServices->datatablesbp($id, $order, $orderby, $search);

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
            if ($pics) {
                $no = 0;
                foreach ($pics as $key) {
                    $no++;
                    $filename = $competitor->comptname . $no;
                    $transType = find_type()->in([DBTypes::comppics])->get(DBTypes::comppics)->getId();
                    $file = new FileUploader($key, $filename, 'images/', $transType, $competitor->comptid);
                    $file->upload();
                }
            }
            DB::commit();
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

    public function update($id, Request $req, CompetitorServices $modelCompetitorServices, Files $modelFiles)
    {

        DB::beginTransaction();
        try {
            $row = $modelCompetitorServices->findOrFail($id);

            $update = collect($req->only($modelCompetitorServices->getFillable()))
                ->except('createdby');
            $row->update($update->toArray());

            if ($req->hasFile('comptpics')) {
                $transType = find_type()->in([DBTypes::bpcustpic])->get(DBTypes::bpcustpic)->getId();

                $files = $modelFiles->where('refid', $id)->where('transtypeid', $transType)->get();
                foreach ($files as $key) {
                    $key->delete();
                }

                $pics = $req->file('comptpics');
                if ($pics) {
                    $no = 0;
                    foreach ($pics as $key) {
                        $no++;
                        $filename = $row->comptname . $no;
                        $transType = find_type()->in([DBTypes::comppics])->get(DBTypes::comppics)->getId();
                        $file = new FileUploader($key, $filename, 'images/', $transType, $id);
                        $file->upload();
                    }
                }
            }

            DB::commit();
            return response()->json(['message' => \TextMessages::successEdit]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function destroy($id, CompetitorServices $modelCompetitorServices, Files $modelFiles)
    {
        DB::beginTransaction();
        try {
            $transType = find_type()->in([DBTypes::comppics])->get(DBTypes::comppics)->getId();

            $files = $modelFiles->where('refid', $id)->where('transtypeid', $transType)->get();
            foreach ($files as $key) {
                $key->delete();
            }

            $row = $modelCompetitorServices->findOrFail($id);
            $row->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
