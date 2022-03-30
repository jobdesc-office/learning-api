<?php

namespace App\Services\Masters;

use App\Models\Masters\User;
use Illuminate\Support\Facades\DB;

class UserServices extends User
{
    public function find($id)
    {
        return DB::table('msuserdt')
        ->join('msuser', 'msuserdt.userid', '=', 'msuser.userid')
        ->join('mstype', 'msuserdt.userdttypeid', '=', 'mstype.typeid')
        ->join('msbusinesspartner', 'msuserdt.userdtbpid', '=', 'msbusinesspartner.bpid')
        ->select('*')
        ->where('msuserdt.userid', $id)
        ->get();
    }

    public function select($searchValue)
    {
        return $this->newQuery()->select('typeid', 'userdttypeid')
            ->with([
                'usertype' => function ($query) {
                    $query->select('typeid', 'typename');
                }
            ])
            ->where(function ($query) use ($searchValue) {
                $query->where(DB::raw('TRIM(LOWER(typename))'), 'like', "%$searchValue%")
                    ->orWhereHas('usertype', function ($query) use ($searchValue) {
                        $query->where(DB::raw('TRIM(LOWER(typename))'), 'like', "%$searchValue%");
                    });
            })
            ->get();
    }

    public function datatables()
    {
        return $this->newQuery()->select('userid', 'userfullname', 'useremail', 'userphone', 'isactive');
    }
}
