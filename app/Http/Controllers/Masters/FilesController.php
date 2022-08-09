<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Services\Masters\FilesServices;
use App\Services\Masters\SubdistrictServices;
use App\Collections\Files\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DBTypes;
use Exception;

class FilesController extends Controller
{

    public function datatables(Request $req, FilesServices $Fileservice)
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
        $query = $Fileservice->datatables($order, $orderby, $search);

        return
            datatables()->eloquent($query)
            ->toJson()
            ->getOriginalContent();
    }

    public function all(Request $req, FilesServices $bpcustomerservice)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $bpcustomerservice->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function storeProspect(Request $req, FilesServices $fileServices)
    {
        DB::beginTransaction();
        try {
            $id = $req->get('id');
            $name = $req->get('name');
            $pics = $req->file('files');
            if ($pics) {
                $no = 0;
                foreach ($pics as $key) {
                    $no++;
                    $mytime = Carbon::now()->format('Y-m-d H-i-s');
                    $filename =  $name . '-' . $no . '-' . $mytime;
                    $transType = find_type()->in([DBTypes::prospectfile])->get(DBTypes::prospectfile)->getId();
                    $file = new FileUploader($key, $filename, 'prospect/', $transType, $id);
                    $file->upload();
                }
            }
            DB::commit();
            return response()->json(['message' => \TextMessages::successCreate]);
        } catch (Exception $th) {
            DB::rollBack();
        }
    }

    public function show($id, FilesServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function destroy($id, FilesServices $modelFileServices)
    {
        DB::beginTransaction();
        try {
            $modelFileServices->findOrFail($id)->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
