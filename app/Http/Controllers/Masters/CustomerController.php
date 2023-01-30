<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\CustomerService;
use App\Services\Masters\ContactPersonServices;
use App\Services\Masters\BpCustomerService;
use App\Models\Masters\Customer;
use App\Models\Masters\ContactPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Collections\Files\FileUploader;
use App\Models\Masters\BpCustomer;
use App\Services\Masters\BpQuotaServices;
use DBTypes;
use Exception;

class CustomerController extends Controller
{

    public function select(Request $req, CustomerService $customerService)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $customerService->select($searchValue);

        return response()->json($selects);
    }

    public function datatables(Request $req, CustomerService $customerService)
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
        $query = $customerService->datatables($order, $orderby, $search);

        return datatables()->eloquent($query)
            ->toJson();
    }

    public function all(Request $req, CustomerService $customerService)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $customerService->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function storeCustomer(Request $req, Customer $modelCustomer, BpCustomerService $modelBpCustomerService, BpQuotaServices $quotaServices)
    {
        if (!$quotaServices->isAllowAddCustomer(1)) return response()->json(['message' => "Customer " . \TextMessages::limitReached], 400);
        $isregistered = $req->get('isregistered');
        $stat = $req->get('sbccstmstatusid');
        switch ($stat) {
            case 'Pro':
                $stat = find_type()->in([DBTypes::cstmstatuspros])->get(DBTypes::cstmstatuspros)->getId();
                break;

            default:
                $stat = find_type()->in([DBTypes::cstmstatuscust])->get(DBTypes::cstmstatuscust)->getId();
                break;
        }
        if ($isregistered == 'true') {
            DB::beginTransaction();
            try {
                $insertt = collect($req->all())->filter()->put('sbccstmstatusid', $stat);

                $modelBpCustomerService->createCustomerWeb($insertt);
                DB::commit();
                return response()->json(['message' => \TextMessages::successCreate]);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(['message' => \TextMessages::failedCreate, 'causes' => $th]);
            }
        } else {
            DB::beginTransaction();
            try {
                $insert = collect($req->only($modelCustomer->getFillable()))->except('updatedby');
                $resultCustomer = $modelCustomer->create($insert->toArray());
                if ($resultCustomer) {
                    $BpCustomer = $modelBpCustomerService->create([
                        'sbcbpid' => $req->get('sbcbpid'),
                        'sbccstmid' => $resultCustomer->cstmid,
                        'sbccstmstatusid' => $stat,
                        'sbccstmname' => $resultCustomer->cstmname,
                        'sbccstmphone' => $resultCustomer->cstmphone,
                        'sbccstmaddress' => $resultCustomer->cstmaddress,
                        'createdby' => $req->get('createdby'),
                    ]);
                    if ($req->has('sbccstmpic')) {
                        $filename = $resultCustomer->cstmname;
                        $transType = find_type()->in([DBTypes::bpcustpic])->get(DBTypes::bpcustpic)->getId();
                        $file = new FileUploader($req->file('sbccstmpic'), $filename, 'images/', $transType, $BpCustomer->sbcid);
                        $resultCustomer  = $resultCustomer && $file->upload() != null;
                    }
                }
                DB::commit();
                return response()->json(['message' => \TextMessages::successCreate]);
            } catch (Exception $th) {
                DB::rollBack();
                return response()->json(['message' => \TextMessages::failedCreate, 'causes' => $th]);
            }
        }
    }

    public function store(Request $req, CustomerService $modelCustomerService)
    {
        $insert = collect($req->only($modelCustomerService->getFillable()))->filter()->except('updatedby');

        $modelCustomerService->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, CustomerService $customerService)
    {
        $row = $customerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, CustomerService $modelCustomerService, BpCustomer $bp)
    {
        DB::beginTransaction();
        try {
            $row = $modelCustomerService->findOrFail($id);
            $bp->select('*')->where('sbccstmid', $id)->update([
                'sbccstmname' => $req->get('cstmname'),
                'sbccstmphone' => $req->get('cstmphone'),
                'sbccstmaddress' => $req->get('cstmaddress'),
            ]);

            $update = collect($req->only($modelCustomerService->getFillable()))
                ->except('createdby');
            $row->update($update->toArray());

            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th]);
        }
    }

    public function destroy($id, CustomerService $modelCustomerService, ContactPersonServices $modelContactPersonServices, BpCustomerService $modelBpCustomerService)
    {
        DB::beginTransaction();
        try {
            $modelContactPersonServices->where('contactcustomerid', $id)->delete();
            $modelBpCustomerService->where('sbccstmid', $id)->delete();
            $modelCustomerService->findOrFail($id)->delete();

            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
