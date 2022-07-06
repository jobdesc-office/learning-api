<?php

namespace App\Services\Masters;

use App\Models\Masters\Village;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class VillageServices extends Village
{
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

        $Villagewhere = $whereArr->only($this->getFillable());
        if ($Villagewhere->isNotEmpty()) {
            $query = $query->where($Villagewhere->toArray());
        }

        if ($whereArr->has('search')) {
            $query = $query->where(DB::raw('TRIM(LOWER(villagename))'), 'like', "%" . Str::lower($whereArr->get('search')) . "%");
        }

        return $query->get();
    }

    public function byName($name)
    {
        $Village = null;
        $remain_count = 0;

        $name_lower = Str::lower($name);
        $Villages = $this->getQuery()->where(DB::raw('TRIM(LOWER(villagename))'), 'like', "%$name_lower%")->get();
        foreach ($Villages as $key => $Village) {
            $remain_characters = Str::replace($name_lower, '', Str::lower($Village->villagename));
            if ($key == 0) {
                $remain_count = strlen($remain_characters);
                $Village = $Village;
            } else {
                if (strlen($remain_characters) < $remain_count) {
                    $remain_count = strlen($remain_characters);
                    $Village = $Village;
                }
            }
        }

        return $Village;
    }

    public function placesByName(Collection $placesName)
    {
        $villageName = Str::lower($placesName->get('village'));
        $subdistrictName = Str::lower($placesName->get('subdistrict'));
        $cityName = Str::lower($placesName->get('city'));
        $provinceName = Str::lower($placesName->get('province'));

        $query = $this->newQuery();
        $query->with([
            'villagesubdistrict' => function ($query) {
                $query->with([
                    'subdistrictcity' => function ($query) {
                        $query->with([
                            'cityprov'
                        ]);
                    },
                ]);
            },
        ]);
        $query->where(DB::raw('TRIM(LOWER(villagename))'), 'like', "%$villageName%");
        $query->whereHas('villagesubdistrict', function ($query) use ($subdistrictName, $cityName, $provinceName) {
            $query->where(DB::raw('TRIM(LOWER(subdistrictname))'), 'like', "%$subdistrictName%");
            $query->whereHas('subdistrictcity', function ($query) use ($cityName, $provinceName) {
                $query->where(DB::raw('TRIM(LOWER(cityname))'), 'like', "%$cityName%");
                $query->whereHas('cityprov', function ($query) use ($provinceName) {
                    $query->where(DB::raw('TRIM(LOWER(provname))'), 'like', "%$provinceName%");
                });
            });
        });
        return $query->get();
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'villagesubdistrict' => function ($query) {
                $query->select('subdistrictid', 'subdistrictname');
            }
        ]);
    }
}
