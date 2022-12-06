<?php

namespace App\Services\Masters;

use App\Models\Masters\SecurityGroup;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SecurityGroupServices extends SecurityGroup
{

    public function byCodes($code)
    {
        return $this->newQuery()->select('sgid')
            ->with([
                'usercreatedby',
                'userupdatedby',
            ])
            ->where('sgcode', $code)->get();
    }

    public function byCodeAdd($code, $searchValue)
    {
        return $this->newQuery()->select('sgid', 'sgcode', 'sgname', 'sgmasterid')
            ->whereHas('parent', function ($query) use ($code) {
                $query->where('sgcode', $code);
            })
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(sgname))'), 'like', "%$searchValue%");
            })
            ->with([
                'usercreatedby',
                'userupdatedby',
            ])
            ->orderBy('sgname', 'asc')
            ->get();
    }

    public function byCode($code, $search = "")
    {
        return $this->newQuery()->select('sgid', 'sgcode', 'sgname', 'sgmasterid')
            ->whereHas('parent', function ($query) use ($code) {
                $query->where('sgcode', $code);
            })
            ->where(DB::raw('TRIM(LOWER(sgname))'), 'like', "%$search%")
            ->with([
                'usercreatedby',
                'userupdatedby',
            ])
            ->orderBy('sgname', 'asc')
            ->get();
    }

    public function byCodeMaster($code)
    {
        return $this->newQuery()
            ->where('sgcode', $code)
            ->with([
                'usercreatedby',
                'userupdatedby',
            ])
            ->get();
    }

    public function bySeq($code)
    {
        return $this->newQuery()->select('sgid', 'sgcode', 'sgname')
            ->whereHas('parent', function ($query) use ($code) {
                $query->where('sgcode', $code);
            })
            ->with([
                'usercreatedby',
                'userupdatedby',
            ])
            ->get();
    }

    public function byParentId($code)
    {
        return $this->newQuery()
            ->with([
                'usercreatedby',
                'userupdatedby',
                'children',
            ])
            ->where('sgmasterid', $code)
            ->orderBy('sgname', 'asc')
            ->get();
    }

    public function datatables($order, $orderby, $search, $bpid, $masterid = null)
    {
        $query =  $this->newQuery();
        $query = $this->selectParent($query);
        return $query->where(function ($query) use ($search, $order, $bpid, $masterid) {
            $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
            $query->where('sgbpid', $bpid);

            if ($masterid == null) $query->whereNull('sgmasterid');
            else $query->where('sgmasterid', $masterid);
        })
            ->orderBy($order, $orderby);
    }

    public function selectParent($query)
    {
        return $query->select("*")->with(
            [
                'usercreatedby',
                'userupdatedby',
                'parent' => function ($query) {
                    return $this->selectParent($query);
                }
            ]
        );
    }

    public function getAll(Collection $where)
    {
        $query =  $this->newQuery();
        return $query->where(function ($query) use ($where) {
            $search = $where->get('searchValue');
            $query->where(DB::raw("TRIM(LOWER(sgname))"), 'like', "%$search%");
            $query->where('sgbpid', $where->get('sgbpid'));
        })->get();
    }

    public function find($id)
    {
        return $this->newQuery()
            ->with([
                'usercreatedby',
                'userupdatedby',
            ])
            ->findOrFail($id);
    }
}
