<?php

namespace App\Services\Masters;

use App\Models\Masters\Information;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class InformationServices extends Information
{

    public function select($searchValue)
    {
        return $this->getQuery()->select('*')
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(Informationname))'), 'like', "%$searchValue%");
            })
            ->orderBy('Informationname', 'asc')
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
        return $this->getQuery()->findOrFail($id);
    }

    public function getAll(Collection $whereArr)
    {
        $query = $this->getQuery();

        $Informationwhere = $whereArr->only($this->fillable);
        if ($Informationwhere->isNotEmpty()) {
            $query = $query->where($Informationwhere->toArray());
        }

        if ($whereArr->has("search")) {
            $query = $query->where(DB::raw('TRIM(LOWER(Informationname))'), 'like', "%" . Str::lower($whereArr->get('search')) . "%");
        }

        return $query->get();
    }

    public function byName($name)
    {
        $Information = null;
        $remain_count = 0;

        $name_lower = Str::lower($name);
        $Informations = $this->getQuery()->where(DB::raw('TRIM(LOWER(Informationname))'), 'like', "%$name_lower%")->get();
        foreach ($Informations as $key => $Information) {
            $remain_characters = Str::replace($name_lower, '', Str::lower($Information->Informationname));
            if ($key == 0) {
                $remain_count = strlen($remain_characters);
                $Information = $Information;
            } else {
                if (strlen($remain_characters) < $remain_count) {
                    $remain_count = strlen($remain_characters);
                    $Information = $Information;
                }
            }
        }

        return $Information;
    }

    public function getQuery()
    {
        return $this->newQuery();
    }
}
