<?php

namespace App\Services\Masters;

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

        $bpcustomerwhere = $whereArr->only($this->getFillable());
        if ($bpcustomerwhere->isNotEmpty()) {
            $query = $query->where($bpcustomerwhere->toArray());
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
        ]);
    }


    public function saveOrGet(Collection $data)
    {
        $data = $data->only($this->getFillable());
        $customer = $this->getQuery()
            ->where(DB::raw('TRIM(LOWER(cstmname))'), Str::lower($data->get('cstmname')))
            ->where(DB::raw('TRIM(LOWER(cstmaddress))'), Str::lower($data->get('cstmaddress')))
            ->where('cstmphone', Str::lower($data->get('cstmphone')))
            ->where('cstmtypeid', Str::lower($data->get('cstmtypeid')))
            ->get();

        if ($customer->count() > 0) {
            return $customer->first();
        } else {
            $customer = $this->fill($data->toArray());
            $customer->save();
            return $customer;
        }
    }
}
