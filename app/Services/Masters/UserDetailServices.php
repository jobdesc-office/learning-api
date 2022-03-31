<?php

namespace App\Services\Masters;

use App\Models\Masters\UserDetail;

class UserDetailServices extends UserDetail
{
    public function find($id)
    {
        return $this->newQuery()
        ->join('msuser', 'msuserdt.userid', '=', 'msuser.userid')
        ->with([
            'usertype' => function($query) {
                $query->select('typeid', 'typename');
            },
            'businesspartner' => function($query) {
                $query->select('bpid', 'bpname');
            }
        ])
        ->findOrFail($id);
    }
}
