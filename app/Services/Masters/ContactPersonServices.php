<?php

namespace App\Services\Masters;

use App\Models\Masters\ContactPerson;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ContactPersonServices extends ContactPerson
{
    public function datatables($order, $orderby)
    {
        return $this->getQuery()->orderBy($order, $orderby);
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

        if ($whereArr->has("search")) {
            $query = $query->where(DB::raw('TRIM(LOWER(contactvalueid))'), 'like', "%" . Str::lower($whereArr->get('search')) . "%");
        }

        return $query->get();
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'contactcustomer',
            'contacttype' => function ($query) {
                $query->select('typeid', 'typename');
            },
        ]);
    }
}
