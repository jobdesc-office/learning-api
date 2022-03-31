<?php

namespace App\Services\Masters;

use App\Models\Masters\BusinessPartner;
use Illuminate\Support\Facades\DB;

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

    public function select($searchValue)
    {
        return $this->newQuery()
        ->with([
            'bptype' => function($query) {
                $query->select('typeid', 'typename');
            }
        ])
        ->where(function ($query) use ($searchValue) {
            $query->where(DB::raw('TRIM(LOWER(bpname))'), 'like', "%$searchValue%");
        })
        ->limit(3)
        ->get();
    }
}
