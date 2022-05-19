<?php

namespace App\Services\Masters;

use App\Models\Masters\BusinessPartner;
use App\Models\Masters\User;
use App\Models\Masters\UserDetail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BusinessPartnerServices extends BusinessPartner
{

    public function datatables()
    {
        return $this->getQuery();
    }

    public function find($id)
    {
        return $this->getQuery()
            ->findOrFail($id);
    }

    public function select($searchValue)
    {
        return $this->newQuery()->select('*')
            ->where(function ($query) use ($searchValue) {
                $query->where(DB::raw('TRIM(LOWER(bpname))'), 'like', "%$searchValue%");
            })
            ->get();
    }

    public function getAll(Collection $whereArr)
    {
        $bp = $this;
        if (isset($whereArr['search'])) {
            $bp = $bp->searchQuery($whereArr['search']);
        }

        if (isset($whereArr['userid'])) {
            $bp = $bp->whereHas(
                'userdetail',
                function ($query) use ($whereArr) {
                    $query->where('userid', $whereArr['userid']);
                }
            );
        }

        if (!$whereArr->only($this->getFillable())->isEmpty()) {
            $bp = $bp->where($whereArr->only($this->getFillable())->toArray());
        }

        return $bp->get();
    }

    public function searchQuery($searchValue)
    {
        return $this->getQuery()
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(bpname))'), 'like', "%$searchValue%");
            });
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'bptype' => function ($query) {
                $query->select('typeid', 'typename');
            }
        ]);
    }
}
