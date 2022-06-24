<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Prospect;
use App\Models\Masters\ProspectProduct;
use App\Models\Masters\ProspectDetail;
use App\Models\Masters\ProspectAssign;
use App\Services\Masters\ProspectServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProspectController extends Controller
{

    public function select(Request $req, ProspectServices $ProspectServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $ProspectServices->select($searchValue);

        return response()->json($selects);
    }

    public function datatables(Request $req, ProspectServices $ProspectServices)
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
        $query = $ProspectServices->datatables($order, $orderby, $search);

        return
            datatables()->eloquent($query)
            ->toJson()
            ->getOriginalContent();
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

        $products = json_decode($req->get('products'));
        if ($products) {
            $ProspectProduct->where('prosproductprospectid', $id)->delete();
            foreach ($products as $product) {
                $ProspectProduct->create([
                    'prosproductprospectid' => $id,
                    'prosproductproductid' => $product->item,
                    'prosproductprice' => $product->price,
                    'prosproductqty' => $product->quantity,
                    'prosproducttax' => $product->tax,
                    'prosproductdiscount' => $product->discount,
                    'prosproductamount' => $product->amount,
                    'prosproducttaxtypeid' => $product->taxtype,
                ]);
            }
        }

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, Prospect $ProspectModel, ProspectProduct $ProspectProduct, ProspectDetail $ProspectDetailModel, ProspectAssign $ProspectAssignModel)
    {
        DB::beginTransaction();
        try {
            $ProspectAssignModel->select('prospectid')->where('prospectid', $id)->delete();
            $ProspectDetailModel->select('prosproductid')->where('prosproductprospectid', $id)->delete();
            $ProspectProduct->select('prospectdtprospectid')->where('prospectdtprospectid', $id)->delete();
            $ProspectModel->findOrFail($id)->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
