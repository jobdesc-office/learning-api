<?php

namespace App\Services\Masters;

use App\Models\Masters\UserDetail;
use Illuminate\Support\Facades\DB;

class UserDetailServices extends UserDetail
{
    public function find($id)
    {
        return $this->newQuery()
            ->select('*')
            ->join('msuser', 'msuserdt.userid', '=', 'msuser.userid')
            ->join('mstype', 'msuserdt.userdttypeid ', '=', 'mstype.typeid')
            ->join('msbusinesspartner', 'msuserdt.userdtbpid', '=', 'msbusinesspartner.bpid')
            ->where('msuserdt.userid', $id)
            ->get();
    }
}
