<?php

namespace App\Services\Masters;

use App\Collections\Files\FileFinder;
use App\Collections\Files\FileUploader;
use App\Models\Masters\BpCustomer;
use DBTypes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use TempFile;

class BpCustomerService extends BpCustomer
{

    public function selectBp($id, $searchValue)
    {
        return $this
            ->newQuery()->with([
                'bpcustcreatedby',
                'bpcustupdatedby',
                'sbccstmstatus' => function ($query) {
                    $query->select('typeid', 'typename');
                },
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
            ])
            // ->getQuery()
            ->select('*')
            ->where('sbcbpid', $id)
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(sbccstmname))'), 'like', "%$searchValue%");
            })
            ->orderBy('sbccstmname', 'asc')
            ->get();
    }

    public function select($searchValue)
    {
        return $this
            ->newQuery()->with([
                'bpcustcreatedby',
                'bpcustupdatedby',
                'sbccstmstatus' => function ($query) {
                    $query->select('typeid', 'typename');
                },
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
            ])
            // ->getQuery()
            ->select('*')
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(sbccstmname))'), 'like', "%$searchValue%");
            })
            ->orderBy('sbccstmname', 'asc')
            ->get();
    }

    public function datatables($order, $orderby, $search)
    {
        return $this
            ->newQuery()->with([
                'bpcustcreatedby',
                'bpcustupdatedby',
                'sbccstmstatus' => function ($query) {
                    $query->select('typeid', 'typename');
                },
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
            ])
            // ->getQuery()
            ->where(function ($query) use ($search, $order) {
                $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
            })
            ->orderBy($order, $orderby);
    }

    public function datatablesbp($id, $order, $orderby, $search, $where)
    {
        return $this
            ->newQuery()->with([
                'bpcustcreatedby',
                'bpcustupdatedby',
                'sbccstmstatus' => function ($query) {
                    $query->select('typeid', 'typename');
                },
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
            ])
            // ->getQuery()
            ->where('sbcbpid', $id)
            ->where(function ($query) use ($search, $order) {
                $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
            })
            // ->where($where)
            ->orderBy($order, $orderby);
    }

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

        // search by customer fields
        $customerServices = new CustomerService();
        $customerwhere = $whereArr->only($customerServices->fillable);
        if ($customerwhere->isNotEmpty()) {
            $query = $query->whereHas('sbccstm', function ($query) use ($customerwhere) {
                $query->where($customerwhere->toArray());
            });
        }

        if ($whereArr->has('search')) {
            $query = $query->where(DB::raw('TRIM(LOWER(sbccstmname))'), 'like', "%" . Str::lower($whereArr->get('search')) . "%");
        }

        return $query->get();
    }

    public function getQuery()
    {
        return $this->newQuery()
            ->with([
                'bpcustcreatedby',
                'bpcustupdatedby',
                'sbccstmstatus' => function ($query) {
                    $query->select('typeid', 'typename');
                },
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
                'sbccstmpics' => function ($query) {
                    $query->addSelect(DB::raw("*,concat('" . url('storage') . "', '/', \"directories\", '',\"filename\") as url"))
                        ->whereHas('transtype', function ($query) {
                            $query->where('typecd', DBTypes::bpcustpic);
                        });
                },
            ]);
    }

    public function createCustomerWeb(Collection $insertArr)
    {
        $customerService = new CustomerService;
        $bpcustomer = $this->fill($insertArr->toArray());
        if ($insertArr->has('cstmid')) {
            try {
                $customer = $customerService->find($insertArr->get('cstmid'));
                $customer = $customer->fill($insertArr->toArray());
                if ($customer->save()) {

                    $bpcustomer->sbccstmid =  $customer->cstmid;
                    $bpcustomer->sbccstmname =  $customer->cstmname;
                    $bpcustomer->sbccstmaddress =  $customer->cstmaddress;
                    $bpcustomer->sbccstmphone =  $customer->cstmphone;
                } else {
                    return false;
                }
            } catch (\Throwable $th) {
                var_dump($th);
                return $th;
            }
        } else {
            $customer = $customerService->fill($insertArr->toArray());
            $customer->save();

            $isExist = $this->where('sbccstmid', $customer->cstmid)->where('sbcbpid', $insertArr->get('sbcbpid'))->first();

            if ($isExist) {
                return false;
            }

            $bpcustomer->sbccstmid =  $customer->cstmid;
            $bpcustomer->sbccstmname =  $customer->cstmname;
            $bpcustomer->sbccstmaddress =  $customer->cstmaddress;
            $bpcustomer->sbccstmphone =  $customer->cstmphone;
        }

        $result =  $bpcustomer->save();
        if ($insertArr->has('sbccstmpic')) {
            // $tempfile = new TempFile();

            $filename = $customer->cstmname;
            $transType = find_type()->in([DBTypes::bpcustpic])->get(DBTypes::bpcustpic)->getId();
            $file = new FileUploader($insertArr->get('sbccstmpic'), $filename, 'images/', $transType, $bpcustomer->sbcid);
            $result  = $result && $file->upload() != null;
        }

        return $result;
    }

    public function createCustomer(Collection $insertArr)
    {
        $customerService = new CustomerService;
        $bpcustomer = $this->fill($insertArr->toArray());
        if ($insertArr->has('cstmid')) {
            $customer = $customerService->find($insertArr->get('cstmid'));
            $customer = $customer->fill($insertArr->toArray());

            if ($customer->save()) {

                $bpcustomer->sbccstmid =  $customer->cstmid;
                $bpcustomer->sbccstmname =  $customer->cstmname;
                $bpcustomer->sbccstmaddress =  $customer->cstmaddress;
                $bpcustomer->sbccstmphone =  $customer->cstmphone;
            } else {
                return false;
            }
        } else {
            $customer = $customerService->fill($insertArr->toArray());
            $customer->save();

            $isExist = $this->where('sbccstmid', $customer->cstmid)->where('sbcbpid', $insertArr->get('sbcbpid'))->first();

            if ($isExist) {
                return false;
            }

            $bpcustomer->sbccstmid =  $customer->cstmid;
            $bpcustomer->sbccstmname =  $customer->cstmname;
            $bpcustomer->sbccstmaddress =  $customer->cstmaddress;
            $bpcustomer->sbccstmphone =  $customer->cstmphone;
        }

        $result =  $bpcustomer->save();

        if ($insertArr->has('temp_path') && $insertArr->has('filename')) {
            $transType = find_type()->in([DBTypes::bpcustpic])->get(DBTypes::bpcustpic)->getId();
            $file = new FileUploader($insertArr->get('temp_path'), $insertArr->get('filename'), 'images/', $transType, $bpcustomer->sbcid);
            $result  = $result && $file->upload() != null;
        }

        return $result;
    }

    public function updateCustomerWeb($id, Collection $insertArr)
    {
        $bpCustomer = $this->findOrFail($id);

        $updateCustomer = collect($insertArr->only($this->getFillable()))->filter()
            ->except('createdby');
        $resultCustomer = $bpCustomer->update($updateCustomer->toArray());

        if ($resultCustomer) {
            if ($insertArr->has('sbccstmpic')) {
                $transType = find_type()->in([DBTypes::bpcustpic])->get(DBTypes::bpcustpic)->getId();

                $oldFile = new FileFinder($transType, $bpCustomer->sbcid);
                $filename = null;

                if (count($oldFile->all()) > 0) {
                    $filename = $oldFile->all()[0]->getFilename();
                } else {
                    $filename = $insertArr->get('filename');
                }

                $file = new FileUploader($insertArr->get('sbccstmpic'), $filename, 'images/', $transType, $bpCustomer->sbcid);
                $resultCustomer  = $resultCustomer && $file->upload() != null;
            }
        }

        return $resultCustomer;
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

            if ($insertArr->has('temp_path') && $insertArr->has('filename')) {
                $transType = find_type()->in([DBTypes::bpcustpic])->get(DBTypes::bpcustpic)->getId();

                $oldFile = new FileFinder($transType, $bpCustomer->sbcid);
                $filename = null;

                if (count($oldFile->all()) > 0) {
                    $filename = $oldFile->all()[0]->getFilename();
                } else {
                    $filename = $insertArr->get('filename');
                }

                $file = new FileUploader($insertArr->get('temp_path'), $filename, 'images/', $transType, $bpCustomer->sbcid);
                $resultCustomer  = $resultCustomer && $file->upload() != null;
            }
        }

        return $resultCustomer;
    }
}
