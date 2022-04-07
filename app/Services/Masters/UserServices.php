<?php

namespace App\Services\Masters;

use App\Models\Masters\User;
use Illuminate\Support\Facades\DB;

class UserServices extends User
{
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
        return $this->newQuery()
            ->select('userid', 'userfullname', 'useremail', 'userphone', 'isactive');
    }

    public function find($id)
    {
        return $this->newQuery()->findOrFail($id);
    }
}
