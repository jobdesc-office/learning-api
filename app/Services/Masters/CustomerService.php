<?php

namespace App\Services\Masters;

use App\Models\Masters\Customer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CustomerService extends Customer
{
    public function find($id)
    {
        return $this->newQuery()
            ->with([
                'cstmtype' => function ($query) {
                    $query->select('typeid', 'typename');
                },
            ])
            ->findOrFail($id);
    }

    public function getAll(Collection $whereArr)
    {
        $query = $this->newQuery()
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
}
