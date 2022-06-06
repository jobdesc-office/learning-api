<?php

namespace App\Services\Masters;

use App\Models\Masters\ProspectDetail;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProspectDetailServices extends ProspectDetail
{
    public function datatables()
    {
        return $this->getQuery();
    }

    public function find($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function getAll(Collection $whereArr)
    {
        $query = $this->getQuery();

        $prospectwhere = $whereArr->only($this->fillable);
        if ($prospectwhere->isNotEmpty()) {
            $query = $query->where($prospectwhere->toArray());
        }

        return $query->get();
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'prospectdtprospect',
            'prospectdtcat' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'prospectdttype' => function ($query) {
                $query->select('typeid', 'typename');
            },
        ]);
    }
}
