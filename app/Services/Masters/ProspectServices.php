<?php

namespace App\Services\Masters;

use App\Models\Masters\Prospect;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProspectServices extends Prospect
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

        if ($whereArr->has("search")) {
            $query = $query->where(DB::raw('TRIM(LOWER(prospectname))'), 'like', "%" . Str::lower($whereArr->get('search')) . "%");
        }

        return $query->get();
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'prospectowneruser' => function ($query) {
                $query->with(['user']);
            },
            'prospectassign' => function ($query) {
                $query->select('*')->with(['prospectassignto' => function ($query) {
                    $query->with(['user']);
                }, 'prospectreportto' => function ($query) {
                    $query->with(['user']);
                }]);
            },
            'prospectstage' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'prospectstatus' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'prospecttype' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'prospectbp',
            'prospectcust' => function ($query) {
                $query->with(['sbccstm']);
            },
        ]);
    }
}
