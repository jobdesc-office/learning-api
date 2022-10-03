<?php

namespace App\Services\Masters;

use App\Models\Masters\ActivityCF;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ActivityCFServices extends ActivityCF
{

    public function select($searchValue)
    {
        return $this->getQuery()->select('*')
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(cityname))'), 'like', "%$searchValue%");
            })
            ->orderBy('cityname', 'asc')
            ->get();
    }

    public function findall($id)
    {
        return $this->getQuery()->where('activityid', $id)->get();
    }

    public function find($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'customfield' => function ($query) {
                $query->with([
                    'refprospect' => function ($query) {
                        $query->with([
                            'prospectcust'
                        ]);
                    }, 'refactivity'
                ]);
            }
        ]);
    }
}
