<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Prospect;
use App\Models\Masters\ProspectProduct;
use App\Services\Masters\ProspectServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProspectController extends Controller
{
    public function datatables(Request $req, ProspectServices $ProspectServices)
    {
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
        $query = $ProspectServices->datatables($order, $orderby);

        return datatables()->eloquent($query)
            ->toJson();
    }

    public function all(Request $req, ProspectServices $ProspectServices)
    {
        $Prospects = $ProspectServices->getAll(collect($req->all()));
        return response()->json($Prospects);
    }

    public function store(Request $req, Prospect $ProspectModel, ProspectProduct $ProspectProduct)
    {
        $insert = collect($req->only($ProspectModel->getFillable()))->filter()->except('updatedby');

        $ProspectModel->fill($insert->toArray())->save();

        if ($req->has('products') && $req->get('products') != null) {
            $members = json_decode($req->get('products'));
            foreach ($members as $member) {
                $ProspectProduct->create([
                    'prosproductprospectid' => $ProspectModel->prospectid,
                    'prosproductproductid' => $member->item,
                    'prosproductprice' => $member->price,
                    'prosproductqty' => $member->quantity,
                    'prosproducttax' => $member->tax,
                    'prosproductdiscount' => $member->discount,
                    'prosproductamount' => $member->amount,
                    'prosproducttaxtypeid' => $member->taxtype
                ]);
            }
        }

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ProspectServices $ProspectServices)
    {
        $Prospect = $ProspectServices->find($id);
        return response()->json($Prospect);
    }

    public function update($id, Request $req, Prospect $ProspectModel, ProspectProduct $ProspectProduct)
    {

        $fields = collect($req->only($ProspectModel->getFillable()))->filter()
            ->except('createdby');
        $ProspectModel->findOrFail($id)->update($fields->toArray());

        // if ($req->has('members') && $req->get('members') != null) {
        //     $ProspectGuestModel->where('scheid', $id);

        //     $members = json_decode($req->get('members'));
        //     foreach ($members as $member) {
        //         $ProspectGuestModel->update([
        //             'scheid' => $ProspectModel->scheid,
        //             'scheuserid' => $member->scheuserid,
        //             'schebpid' => $member->schebpid,
        //             'schepermisid' => $member->schepermisid
        //         ]);
        //     }
        // }

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, Prospect $ProspectModel, ProspectProduct $ProspectProduct)
    {
        DB::beginTransaction();
        try {
            $ProspectProduct->select('prosproductid')->where('prosproductprospectid', $id)->delete();
            $ProspectModel->findOrFail($id)->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
