<?php

namespace App\Services\Masters;

use App\Models\Masters\Stbptype;

class StBpTypeServices extends Stbptype
{
    public function find($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function byCode($code)
    {
        return $this->getQuery()->whereHas('stbptypetype', function ($query) use ($code) {
            $query->where('typecd', $code);
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
            }
        ]);
    }
}
