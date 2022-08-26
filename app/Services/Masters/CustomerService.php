<?php

namespace App\Services\Masters;

use App\Models\Masters\BpCustomer;
use App\Models\Masters\Customer;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CustomerService extends Customer
{

    public function select($searchValue)
    {
        return $this->getQuery()->select('*')
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(cstmname))'), 'like', "%$searchValue%");
            })
            ->orderBy('cstmname', 'asc')
            ->get();
    }

    public function datatables($order, $orderby, $search)
    {
        return $this->getQuery()
            ->where(function ($query) use ($search, $order) {
                $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
            })
            ->orderBy($order, $orderby);
    }

    public function find($id)
    {
        return $this->getQuery()
            ->with([
                'cstmtype' => function ($query) {
                    $query->select('typeid', 'typename');
                },
            ])
            ->findOrFail($id);
    }

    public function getAll(Collection $whereArr)
    {
        $query = $this->getQuery()
            ->with([
                'cstmtype' => function ($query) {
                    $query->select('typeid', 'typename');
                },
            ]);

        $customerwhere = $whereArr->only($this->getFillable());
        if ($customerwhere->isNotEmpty()) {
            $query = $query->where($customerwhere->toArray());
        }

        if ($whereArr->has('search')) {
            $query = $query->where(DB::raw('TRIM(LOWER(cstmname))'), 'like', "%" . Str::lower($whereArr->get('search')) . "%");
        }

        return $query->get();
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'cstmtype' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'cstmprovince' => function ($query) {
                $query->select('provid', 'provname');
            },
            'cstmcity' => function ($query) {
                $query->select('cityid', 'cityname');
            },
            'cstmsubdistrict' => function ($query) {
                $query->select('subdistrictid', 'subdistrictname');
            },
            'cstmvillage' => function ($query) {
                $query->select('villageid', 'villagename');
            },
        ]);
    }
}
