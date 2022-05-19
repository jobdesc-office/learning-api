<?php

namespace App\Services\Masters;

use App\Models\Masters\BpCustomer;
use App\Models\Masters\Customer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BpCustomerService extends BpCustomer
{
    public function find($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function getAll(Collection $whereArr)
    {
        $query = $this->getQuery();

        $bpcustomerwhere = $whereArr->only($this->fillable);
        if ($bpcustomerwhere->isNotEmpty()) {
            $query = $query->where($bpcustomerwhere->toArray());
        }

        return $query->get();
    }

    public function getQuery()
    {
        return $this->newQuery()
            ->with([
                'sbcbp' => function ($query) {
                    $query->select('bpid', 'bpname');
                },
                'sbccstm' => function ($query) {
                    $query->select('*')->with([
                        'cstmtype' => function ($query) {
                            $query->select('typeid', 'typename');
                        },
                    ]);
                },
            ]);
    }

    public function createCustomer(Collection $insertArr)
    {
        $customerService = new CustomerService;
        $bpcustomer = $this->fill($insertArr->toArray());
        if ($insertArr->has('cstmid')) {
            $customer = $customerService->find($insertArr->get('cstmid'));
            $customer = $customer->fill($insertArr->toArray());

            if ($customer->save()) {

                if ($insertArr->has('sbccstmpic') && isset($_FILES['sbccstmpic'])) {
                    $bpcustomer->sbccstmpic =  uploadFile('sbccstmpic');
                }
                $bpcustomer->sbccstmid =  $customer->cstmid;
                $bpcustomer->sbccstmname =  $customer->cstmname;
                $bpcustomer->sbccstmaddress =  $customer->cstmaddress;
                $bpcustomer->sbccstmphone =  $customer->cstmphone;
            } else {
                return false;
            }
        } else {
            $customer = $customerService->saveOrGet($insertArr);

            if ($insertArr->has('sbccstmpic') && isset($_FILES['sbccstmpic'])) {
                $bpcustomer->sbccstmpic =  uploadFile('sbccstmpic');
            }

            $bpcustomer->sbccstmid =  $customer->cstmid;
            $bpcustomer->sbccstmname =  $customer->cstmname;
            $bpcustomer->sbccstmaddress =  $customer->cstmaddress;
            $bpcustomer->sbccstmphone =  $customer->cstmphone;
        }
        return $bpcustomer->save();
    }

    public function updateCustomer($id, Collection $insertArr)
    {
        $bpCustomer = $this->find($id);
        $modelCustomerService = new CustomerService;
        $customer = $modelCustomerService->find($bpCustomer->sbccstmid);

        $updateCustomer = collect($insertArr->only($modelCustomerService->getFillable()))->filter()
            ->except('updatedby');
        $resultCustomer = $customer->fill($updateCustomer->toArray())->save();

        if ($resultCustomer) {
            $updateBpCustomer = collect($insertArr->only($this->getFillable()))->filter()
                ->except('updatedby');

            $bpCustomer->fill($updateBpCustomer->toArray());
            $bpCustomer->sbccstmid = $customer->cstmid;
            $bpCustomer->sbccstmname = $customer->cstmname;
            $bpCustomer->sbccstmphone = $customer->cstmphone;
            $bpCustomer->sbccstmaddress = $customer->cstmaddress;
            $resultCustomer = $resultCustomer && $bpCustomer->save();
        }

        return $resultCustomer;
    }
}
