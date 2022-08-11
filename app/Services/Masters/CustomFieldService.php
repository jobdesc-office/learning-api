<?php

namespace App\Services\Masters;

use App\Models\Masters\CustomField;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CustomFieldService extends CustomField
{

    public function selectWithBp($order, $orderby, $search, $bpid)
    {
        return $this->getQuery()
            ->where('custfbpid', $bpid)
            ->where(function ($query) use ($search, $order) {
                $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
            })
            ->orderBy($order, $orderby);
    }

    public function datatablesbp($id, $order, $orderby, $search)
    {
        return $this->getQuery()
            ->where(function ($query) use ($search, $order) {
                $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
            })
            ->where('custfbpid', $id)
            ->orderBy($order, $orderby);
    }

    public function select($searchValue)
    {
        return $this->getQuery()->select('*')
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(custfname))'), 'like', "%$searchValue%");
            })
            ->orderBy('custfname', 'asc')
            ->get();
    }

    public function selectBp($searchValue,  $bpid)
    {
        return $this->getQuery()->select('*')
            ->where('custfbpid', $bpid)
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(custfname))'), 'like', "%$searchValue%");
            })
            ->orderBy('custfname', 'asc')
            ->get();
    }

    public function withBp($bpid)
    {
        return $this->getQuery()->select('*')
            ->where('custfbpid', $bpid)
            ->orderBy('custfname', 'asc')
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
        return $this->getQuery()
            ->findOrFail($id);
    }

    public function getAll(Collection $whereArr)
    {
        $query = $this->getQuery()
            ->with([
                'businesspartner' => function ($query) {
                    $query->select('bpid', 'bpname');
                },
                'custftype' => function ($query) {
                    $query->select('typeid', 'typename');
                },
            ]);

        $bpCustomFieldwhere = $whereArr->only($this->getFillable());
        if ($bpCustomFieldwhere->isNotEmpty()) {
            $query = $query->where($bpCustomFieldwhere->toArray());
        }

        if ($whereArr->has('search')) {
            $query = $query->where(DB::raw('TRIM(LOWER(cstmname))'), 'like', "%" . Str::lower($whereArr->get('search')) . "%");
        }

        return $query->get();
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'businesspartner' => function ($query) {
                $query->select('bpid', 'bpname');
            },
            'custftype' => function ($query) {
                $query->select('typeid', 'typename');
            }
        ]);
    }
}
