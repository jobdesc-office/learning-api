<?php

namespace App\Services\Masters;

use App\Models\Masters\User;
use App\Models\Masters\UserDetail;
use Illuminate\Support\Facades\DB;

class UserServices extends User
{
    public function select($searchValue)
    {
        return $this->newQuery()->select('userid', 'userfullname')
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(userfullname))'), 'like', "%$searchValue%");
            })
            ->get();
    }

    public function allUser($searchValue)
    {
        return $this->newQuery()->select('userid', 'userfullname')
            ->where(function ($query) use ($searchValue) {
                $query->where(DB::raw('TRIM(LOWER(userfullname))'), 'like', "%$searchValue%");
            })
            ->get();
    }

    public function getAll($whereArr)
    {
        $users = $this->newQuery()->with([
            'userdetails' => function ($query) use ($whereArr) {

                $userDetailFillable = (new UserDetail())->getFillable();
                if (!$whereArr->only($userDetailFillable)->isEmpty()) {
                    $query->where($whereArr->only($userDetailFillable)->toArray());
                }

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

        $userDetailFillable = (new UserDetail())->getFillable();
        if (!$whereArr->only($userDetailFillable)->isEmpty()) {
            $users = $users->whereHas('userdetails', function ($query) use ($whereArr, $userDetailFillable) {
                $query->where($whereArr->only($userDetailFillable)->toArray());
            });
        }


        if (isset($whereArr['search'])) {
            $users = $users->where(DB::raw('TRIM(LOWER(username))'), 'like', "%$whereArr[search]%");
        }
        return $users->get();
    }

    public function datatables($order, $orderby)
    {
        return $this->newQuery()
            ->select('userid', 'userfullname', 'useremail', 'userphone', 'isactive')

            ->orderBy($order, $orderby);
    }

    public function find($id)
    {
        return $this->newQuery()->findOrFail($id);
    }
}
