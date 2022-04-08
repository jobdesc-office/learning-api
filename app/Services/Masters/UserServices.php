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

    public function getAll($whereArr)
    {
        $users = $this->newQuery()->with([
            'userdetails' => function ($query) {
                $query->select('userid', 'userdttypeid', 'userdtbpid')
                    ->with([
                        'usertype' => function ($query) {
                            $query->select('typeid', 'typename', 'typecd');
                        },
                        'businesspartner' => function ($query) {
                            $query->select('bpid', 'bpname');
                        }
                    ]);
            }
        ]);
        if (!$whereArr->only($this->getFillable())->isEmpty()) {
            $users = $users->where($whereArr->only($this->getFillable())->toArray());
        }

        if (isset($whereArr['search'])) {
            $users = $users->where(DB::raw('TRIM(LOWER(username))'), 'like', "%$whereArr[serach]%");
        }
        return $users->get();
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
