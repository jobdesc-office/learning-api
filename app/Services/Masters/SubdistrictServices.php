<?php

namespace App\Services\Masters;

use App\Models\Masters\Subdistrict;
use Illuminate\Support\Collection;

class SubdistrictServices extends Subdistrict
{
    public function find($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function getAll(Collection $whereArr)
    {
        $query = $this->getQuery();

        $subdistrictwhere = $whereArr->only($this->fillable);
        if ($subdistrictwhere->isNotEmpty()) {
            $query = $query->where($subdistrictwhere->toArray());
        }

        if ($whereArr->has('search')) {
            $query = $query->where('subdistrictname', 'like', "%$whereArr->search%");
        }

        return $query->get();
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'subdistrictcity' => function ($query) {
                $query->select('cityid', 'cityname');
            }
        ]);
    }
}
