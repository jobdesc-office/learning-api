<?php

namespace App\Services\Masters;

use App\Models\Masters\Customer;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CustomerService extends Customer
{
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

        $bpcustomerwhere = $whereArr->only($this->fillable);
        if ($bpcustomerwhere->isNotEmpty()) {
            $query = $query->where($bpcustomerwhere->toArray());
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
        $anchor = [
            DB::raw('TRIM(LOWER(cstmname))') => Str::lower($data->get('cstmname')),
            DB::raw('TRIM(LOWER(cstmaddress))') => Str::lower($data->get('cstmaddress')),
            'cstmphone' => $data->get('cstmphone'),
            'cstmtypeid' => $data->get('cstmtypeid'),
        ];
        $customer = $this->getQuery()->where($anchor)->get();

        if ($customer->count() > 0) {
            return $customer->first();
        } else {
            $customer = $this->fill($data->toArray());
            $customer->save();
            return $customer;
        }
    }
}
