<?php

namespace App\Services\Masters;

use App\Models\Masters\Stbptype;
use DBTypes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StbptypeServices extends Stbptype
{
    public function find($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function datatables($typeid, $bpid)
    {
        return $this->getQuery()
            ->orderBy('sbtname', 'asc')
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
