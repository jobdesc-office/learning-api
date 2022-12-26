<?php

namespace App\Services\Masters;

use App\Models\Masters\Stbptype;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StBpTypeServices extends Stbptype
{
    public function find($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function byCode($code, $bpid, $search = "")
    {
        $search = Str::lower($search);
        return $this->getQuery()->whereHas('stbptypetype', function ($query) use ($code) {
            $query->where('typecd', $code);
        })
            ->where('sbtbpid', $bpid)
            ->where('isactive', true)
            ->where(DB::raw('TRIM(LOWER(sbttypename))'), 'like', "%$search%")
            ->orderBy('sbttypename', 'asc')->get();
    }

    public function byCodeInSecurity($code, $bpid, $search = "")
    {
        $search = Str::lower($search);
        return $this->getQuery()->whereHas('stbptypetype', function ($query) use ($code) {
            $query->where('typecd', $code);
        })
            ->where(function ($query) use ($bpid) {
                $query->where(function ($query) use ($bpid) {
                    $query->where('sbtbpid', $bpid);
                    $query->whereNull('sbtsgid');
                });
                $query->orWhere(function ($query) use ($bpid) {
                    $query->where('sbtbpid', $bpid);
                    $ids = parents()->map(function ($item) {
                        return $item->sgid;
                    })->toArray();
                    $query->whereIn('sbtsgid', $ids);
                });
            })
            ->where('isactive', true)
            ->where(DB::raw('TRIM(LOWER(sbttypename))'), 'like', "%$search%")
            ->orderBy('sbttypename', 'asc')->get();
    }

    public function byCodeAdd($code, $bpid, $searchValue)
    {
        return $this->getQuery()->whereHas('stbptypetype', function ($query) use ($code) {
            $query->where('typecd', $code);
        })
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(sbttypename))'), 'like', "%$searchValue%");
            })
            ->where('sbtbpid', $bpid)
            ->where('isactive', true)
            ->orderBy('sbttypename', 'asc')->get();
    }

    public function bySeq($code, $bpid)
    {
        return $this->getQuery()->whereHas('stbptypetype', function ($query) use ($code) {
            $query->where('typecd', $code);
        })
            ->where('sbtbpid', $bpid)
            ->where('isactive', true)
            ->orderBy('sbtseq', 'asc')->get();
    }

    public function whereParent($code)
    {
        return $this->getQuery()
            ->whereHas('stbptypetype', function ($query) use ($code) {
                $query->whereIn('typecd', array_merge([], $code));
            })->get();
    }

    public function datatables($typeid, $bpid)
    {
        return $this->getQuery()
            ->orderBy('sbtseq', 'asc')
            ->orderBy('sbttypename', 'asc')
            ->where('sbtbpid', $bpid)
            ->where('sbttypemasterid', $typeid)->get();
    }

    public function datatablesBySeq($typeid, $bpid)
    {
        return $this->getQuery()
            ->orderBy('sbtseq', 'asc')
            ->where('sbtbpid', $bpid)
            ->where('sbttypemasterid', $typeid);
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'stbptypecreatedby',
            'stbptypeupdatedby',
            'stbptypetype' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'stbptypebp' => function ($query) {
                $query->select('bpid', 'bpname');
            },
            'securitygroup',
        ]);
    }
}
