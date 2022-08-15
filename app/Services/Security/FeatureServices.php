<?php

namespace App\Services\Security;

use App\Models\Security\Feature;
use Illuminate\Support\Facades\DB;

class FeatureServices extends Feature
{

    public function datatables($id, $order, $orderby, $search)
    {
        return $this->newQuery()
            ->with(['menu'])
            ->where('featmenuid', $id)
            ->where(function ($query) use ($search, $order) {
                $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
            })
            ->orderBy($order, $orderby);
    }

    public function find($id)
    {
        return $this->newQuery()->select('*')
            ->with(['menu'])
            ->findOrFail($id);
    }
}
