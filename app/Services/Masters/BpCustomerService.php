<?php

namespace App\Services\Masters;

use App\Models\Masters\BpCustomer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BpCustomerService extends BpCustomer
{
    public function find($id)
    {
        return $this->newQuery()
            ->with([
                'sbcbp' => function ($query) {
                    $query->select('bpid', 'bpname');
                },
                'sbccustomer' => function ($query) {
                    $query->select('cstmid', 'cstmname');
                },
            ])
            ->findOrFail($id);
    }

    public function getAll(Collection $whereArr)
    {
        $query = $this->newQuery()
            ->with([
                'sbcbp' => function ($query) {
                    $query->select('bpid', 'bpname');
                },
                'sbccustomer' => function ($query) {
                    $query->select('cstmid', 'cstmname');
                },
            ]);

        $bpcustomerwhere = $whereArr->only($this->fillable);
        if ($bpcustomerwhere->isNotEmpty()) {
            $query = $query->where($bpcustomerwhere->toArray());
        }

        return $query->get();
    }
}
