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
    public function all(Request $req, ProspectServices $ProspectServices)
    {
        $Prospects = $ProspectServices->getAll(collect($req->all()));
        return response()->json($Prospects);
    }

    public function store(Request $req, Prospect $ProspectModel, ProspectProduct $ProspectProduct)
    {
        $insert = collect($req->only($ProspectModel->getFillable()))->filter();

        $ProspectModel->fill($insert->toArray())->save();

        if ($req->has('members') && $req->get('members') != null) {
            $members = json_decode($req->get('members'));
            foreach ($members as $member) {
                $ProspectProduct->create([
                    'prospectid' => $ProspectModel->scheid,
                    'prospectproductprice' => $member->scheuserid,
                    'prospectqty' => $member->schebpid,
                    'prospecttax' => $member->schebpid,
                    'prospectdiscount' => $member->schebpid,
                    'prospectamount' => $member->schebpid,
                    'prospecttaxtypeid' => $member->schepermisid
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
        // $Prospect = $ProspectModel->findOrFail($id);

        // $fields = collect($req->only($ProspectModel->getFillable()))->filter()
        //     ->except('createdby');
        // $Prospect->update($fields->toArray());

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

        // return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, Prospect $ProspectModel, ProspectProduct $ProspectProduct)
    {
        // DB::beginTransaction();
        // try {
        //     $ProspectGuest->select('scheid')->where('scheid', $id)->delete();
        //     $ProspectModel->findOrFail($id)->delete();
        //     DB::commit();
        //     return response()->json(['message' => \TextMessages::successDelete]);
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        // }
    }
}
