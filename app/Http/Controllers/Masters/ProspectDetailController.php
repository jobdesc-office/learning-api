<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\ProspectDetail;
use App\Models\Masters\ProspectProduct;
use App\Services\Masters\ProspectDetailServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProspectDetailController extends Controller
{
    public function details(Request $req, ProspectDetailServices $ProspectDetailServices)
    {
        $id = $req->get('id');
        $query = $ProspectDetailServices->details($id);

        return $query->get();
    }

    public function all(Request $req, ProspectDetailServices $ProspectServices)
    {
        $Prospects = $ProspectServices->getAll(collect($req->all()));
        return response()->json($Prospects);
    }

    public function store(Request $req, ProspectDetail $ProspectDetailModel, ProspectProduct $ProspectProduct)
    {
        $insert = collect($req->only($ProspectDetailModel->getFillable()))->filter()->except('updatedby');

        $ProspectDetailModel->fill($insert->toArray())->save();

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ProspectDetailServices $ProspectServices)
    {
        $Prospect = $ProspectServices->find($id);
        return response()->json($Prospect);
    }

    public function update($id, Request $req, ProspectDetail $ProspectDetailModel, ProspectProduct $ProspectProduct)
    {

        $fields = collect($req->only($ProspectDetailModel->getFillable()))->filter()
            ->except('createdby');
        $ProspectDetailModel->findOrFail($id)->update($fields->toArray());

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

    public function destroy($id, ProspectDetail $ProspectDetailModel, ProspectProduct $ProspectProduct)
    {
        DB::beginTransaction();
        try {
            $ProspectProduct->select('prosproductid')->where('prosproductprospectid', $id)->delete();
            $ProspectDetailModel->findOrFail($id)->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
