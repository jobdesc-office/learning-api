<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\BpCustomerService;
use App\Services\Masters\CustomerService;
use App\Services\Masters\FilesServices;
use DB;
use DBTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BpCustomerController extends Controller
{

    public function all(Request $req, BpCustomerService $bpcustomerservice)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $bpcustomerservice->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, BpCustomerService $modelBpCustomerService)
    {

        $insert = collect($req->all())->filter();

        if ($req->hasFile('sbccstmpic')) {
            $file = $req->file('sbccstmpic');
            $filename = Str::replace(['/', '\\', '.'], '', Hash::make(Str::random()));
            $insert->put('temp_path', $file->getPathname());
            $insert->put('filename', $filename);
        }

        $result = $modelBpCustomerService->createCustomer($insert);

        if ($result) {
            return response()->json(['message' => \TextMessages::successCreate,]);
        } else {
            return response()->json(['message' => \TextMessages::failedCreate,], 400);
        }
    }

    public function show($id, BpCustomerService $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, BpCustomerService $modelBpCustomerService)
    {
        $bpCustomer = $modelBpCustomerService->findOrFail($id);
        $insert = collect($req->all())->filter();

        if ($req->hasFile('sbccstmpic')) {
            $file = $req->file('sbccstmpic');
            $filename = Str::replace(['/', '\\', '.'], '', Hash::make(Str::random()));
            $insert->put('temp_path', $file->getPathname());
            $insert->put('filename', $filename);
        }

        $resultCustomer = $modelBpCustomerService->updateCustomer($id, $insert);

        if ($resultCustomer) {
            return response()->json(['message' => \TextMessages::successEdit,]);
        } else {
            return response()->json(['message' => \TextMessages::failedEdit,], 400);
        }
    }

    public function destroy($id, BpCustomerService $modelBpCustomerService, FilesServices $filesServices)
    {
        DB::beginTransaction();
        try {
            $row = $modelBpCustomerService->find($id);

            $bpcustpic = find_type()->in([DBTypes::bpcustpic])->get(DBTypes::bpcustpic)->getId();
            $files = $filesServices->where('refid', $id)->where('trans', $bpcustpic)->get();
            foreach ($files as $file) {
                $file->delete();
            }

            $row->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
        return response()->json(['message' => "failed delete"], 400);
    }
}
