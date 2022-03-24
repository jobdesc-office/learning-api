<?php

namespace App\Services\Masters;

use App\Models\Masters\BusinessPartner;

class BusinessPartnerServices extends BusinessPartner
{

    public function datatables()
    {
        return $this->newQuery()->with([
            'bptype' => function($query) {
                $query->select('typeid', 'typename');
            }
        ]);
    }

    public function find($id)
    {
        return $this->newQuery()->with([
                'bptype' => function($query) {
                    $query->select('typeid', 'typename');
                }
            ])
            ->findOrFail($id);
    }
}
