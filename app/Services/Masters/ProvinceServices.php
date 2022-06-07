<?php

namespace App\Services\Masters;

use App\Models\Masters\Province;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProvinceServices extends Province
{
    public function datatables($order, $orderby)
    {
        return $this->getQuery()

            ->orderBy($order, $orderby);
    }

    public function find($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function getAll(Collection $whereArr)
    {
        $query = $this->getQuery();

        $provincewhere = $whereArr->only($this->fillable);
        if ($provincewhere->isNotEmpty()) {
            $query = $query->where($provincewhere->toArray());
        }

        if ($whereArr->has('search')) {
            $query = $query->where(DB::raw('TRIM(LOWER(provname))'), 'like', "%" . Str::lower($whereArr->get('search')) . "%");
        }

        return $query->get();
    }

    public function byName($name)
    {
        $prov = null;
        $remain_count = 0;

        $name_lower = Str::lower($name);
        $provs = $this->getQuery()->where(DB::raw('TRIM(LOWER(provname))'), 'like', "%$name_lower%")->get();
        foreach ($provs as $key => $prov) {
            $remain_characters = Str::replace($name_lower, '', Str::lower($prov->provname));
            if ($key == 0) {
                $remain_count = strlen($remain_characters);
                $prov = $prov;
            } else {
                if (strlen($remain_characters) < $remain_count) {
                    $remain_count = strlen($remain_characters);
                    $prov = $prov;
                }
            }
        }

        return $prov;
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'provcountry' => function ($query) {
                $query->select('countryid', 'countryname');
            }
        ]);
    }
}
