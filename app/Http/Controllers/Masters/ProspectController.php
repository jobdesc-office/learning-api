<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Collections\Files\FileUploader;
use App\Models\Masters\Prospect;
use App\Models\Masters\ProspectProduct;
use App\Models\Masters\ProspectActivity;
use App\Models\Masters\ProspectAssign;
use App\Models\Masters\ProspectCustomField;
use App\Models\Masters\Customer;
use App\Models\Masters\ContactPerson;
use App\Models\Masters\DailyActivity;
use App\Models\Masters\Product;
use App\Models\Masters\Files;
use App\Services\Masters\BpCustomerService;
use App\Services\Masters\ProspectServices;
use App\Services\Masters\TrHistoryServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DBTypes;
use Exception;

class ProspectController extends Controller
{

    public function prospectHistories(Request $request, TrHistoryServices $trHistoryServices, Prospect $prospect, ProspectProduct $prospectProduct, ProspectAssign $prospectAssign, DailyActivity $dailyActivity, ProspectCustomField $prospectCustomField, Files $files)
    {
        $prospect =  $trHistoryServices->findHistories($request->get('prospectid'), $prospect->getTable(), $request->get('bpid'));
        $product =  $trHistoryServices->findProspectProductHistories($request->get('prospectid'), $prospectProduct->getTable(), $request->get('bpid'));
        $assign =  $trHistoryServices->findProspectAssignHistories($request->get('prospectid'), $prospectAssign->getTable(), $request->get('bpid'));
        $activity =  $trHistoryServices->findProspectActivityHistories($request->get('prospectid'), $dailyActivity->getTable(), $request->get('bpid'));
        $customfield =  $trHistoryServices->findProspectCustomfieldHistories($request->get('prospectid'), $prospectCustomField->getTable(), $request->get('bpid'));
        $file =  $trHistoryServices->findProspectFileHistories($request->get('prospectid'), $files->getTable(), $request->get('bpid'));
        return response()->json(['prospect' => $prospect, 'prospectproduct' => $product, 'prospectassign' => $assign, 'prospectactivity' => $activity, 'prospectcustomfield' => $customfield, 'prospectfile' => $file]);
    }

    public function lastid(ProspectServices $ProspectServices)
    {
        $selects = $ProspectServices->lastid();

        return response()->json($selects);
    }

    public function select(Request $req, ProspectServices $ProspectServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $ProspectServices->select($searchValue);

        return response()->json($selects);
    }

    public function selectref(Request $req, ProspectServices $ProspectServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $ProspectServices->selectref($searchValue);

        return response()->json($selects);
    }

    public function datatablesbp($id, Request $req, ProspectServices $ProspectServices)
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
        $query = $ProspectServices->datatablesbp($id, $order, $orderby, $search);

        return
            datatables()->eloquent($query)
            ->toJson()
            ->getOriginalContent();
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

    public function storeCustomer(Request $req, Customer $modelCustomer, ContactPerson $modelContactPerson, BpCustomerService $modelBpCustomerService)
    {
        $isregistered = $req->get('isregistered');
        if ($isregistered == 'true') {
            DB::beginTransaction();
            try {
                $insert = collect($req->only($modelContactPerson->getFillable()))->filter()
                    ->except('updatedby');

                $modelContactPerson->create($insert->toArray());
                $insertt = collect($req->all())->filter();

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
                        'sbccstmstatusid' => $req->get('sbccstmstatusid'),
                        'sbccstmname' => $resultCustomer->cstmname,
                        'sbccstmphone' => $resultCustomer->cstmphone,
                        'sbccstmaddress' => $resultCustomer->cstmaddress,
                        'createdby' => $req->get('createdby'),
                    ]);
                    $modelContactPerson->create([
                        'contactcustomerid' => $resultCustomer->cstmid,
                        'contacttypeid' => $req->get('contacttypeid'),
                        'contactname' => $req->get('contactname'),
                        'contactvalueid' => $req->get('contactvalueid'),
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

    public function storeProduct(Request $req, Product $ProductModel)
    {
        $insert = collect($req->only($ProductModel->getFillable()))->filter()->except('updatedby');

        $ProductModel->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function store(Request $req, Prospect $ProspectModel, ProspectProduct $ProspectProduct, ProspectServices $modelProspectServices)
    {
        $insert = collect($req->only($ProspectModel->getFillable()))->filter()->except('updatedby');

        $insert->put('prospectcode', $modelProspectServices->generateCode());
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
        $Prospect = $ProspectServices->found($id);
        return response()->json($Prospect);
    }

    public function update($id, Request $req, Prospect $ProspectModel, ProspectProduct $ProspectProduct)
    {

        $fields = collect($req->only($ProspectModel->getFillable()))
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

    public function destroy($id, Prospect $ProspectModel, ProspectProduct $ProspectProduct, ProspectActivity $ProspectActivityModel, ProspectAssign $ProspectAssignModel, ProspectCustomField $ProspectCustomField, Files $modelFile)
    {
        DB::beginTransaction();
        try {
            $modelFile->where('transtypeid', find_type()->in([DBTypes::prospectfile])->get(DBTypes::prospectfile)->getId())->where('refid', $id)->delete();
            $ProspectCustomField->where('prospectid', $id)->delete();
            $ProspectAssignModel->where('prospectid', $id)->delete();
            $ProspectActivityModel->where('prospectactivityprospectid', $id)->delete();
            $ProspectProduct->where('prosproductprospectid', $id)->delete();
            $ProspectModel->findOrFail($id)->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => \TextMessages::failedDelete, 'error' => $th]);
        }
    }
}
