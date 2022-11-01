<?php

namespace App\Services\Masters;

use App\Models\Masters\User;
use App\Models\Masters\UserDetail;
use Illuminate\Support\Facades\DB;

class UserServices extends User
{

    public function getEmployee(int $id)
    {
        return $this->newQuery()->select('msuser.*')
            ->join('msuserdt', 'msuser.userid', '=', 'msuserdt.userid')
            ->where('msuserdt.userdtbpid', $id)->get();
    }

    public function selectwithsamebp($searchValue, $id)
    {
        return $this->newQuery()->select('*')
            ->join('msuserdt', 'msuser.userid', '=', 'msuserdt.userid')
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(userfullname))'), 'like', "%$searchValue%");
            })
            ->where('msuserdt.userdtbpid', $id)
            ->orderBy('userfullname', 'asc')
            ->get();
    }

    public function samebp($id)
    {
        return $this->newQuery()->select('*')
            ->join('msuserdt', 'msuser.userid', '=', 'msuserdt.userid')
            ->where('msuserdt.userdtbpid', $id)
            ->orderBy('userfullname', 'asc')
            ->get();
    }

    public function select($searchValue)
    {
        return $this->newQuery()->select('*')
            ->where(function ($query) use ($searchValue) {
                $searchValue = trim(strtolower($searchValue));
                $query->where(DB::raw('TRIM(LOWER(userfullname))'), 'like', "%$searchValue%");
            })
            ->orderBy('userfullname', 'asc')
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
            'usercreatedby',
            'userupdatedby',
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
                            $query->select('bpid', 'bpname', 'bpemail', 'bpphone')->with(['bptype']);
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

    public function datatables($order, $orderby, $search)
    {
        return $this->newQuery()->with([
            'usercreatedby',
            'userupdatedby',
            'userdetails' => function ($query) {
                $query->select('*')->with([
                    'usertype' => function ($query) {
                        $query->select('typeid', 'typename');
                    },
                    'businesspartner' => function ($query) {
                        $query->select('bpid', 'bpname', 'bpemail', 'bpphone')->with(['bptype']);
                    }
                ]);
            }
        ])
            ->where(function ($query) use ($search, $order) {
                $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
            })
            ->orderBy($order, $orderby);
    }

    public function datatablesbp($id, $order, $orderby, $search)
    {
        return $this->newQuery()->select('msuser.*')->with([
            'usercreatedby',
            'userupdatedby',
            'userdetails' => function ($query) {
                $query->select('*')->with([
                    'usertype' => function ($query) {
                        $query->select('typeid', 'typename');
                    },
                    'businesspartner' => function ($query) {
                        $query->select('bpid', 'bpname', 'bpemail', 'bpphone')->with(['bptype']);
                    }
                ]);
            }
        ])


            ->join('msuserdt', 'msuser.userid', '=', 'msuserdt.userid')
            ->where('msuserdt.userdtbpid', $id)
            ->where(function ($query) use ($search, $order) {
                $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
            })
            ->orderBy($order, $orderby);
    }

    public function find($id)
    {
        return $this->newQuery()->with([
            'usercreatedby',
            'userupdatedby',
            'userdetails' => function ($query) {
                $query->select('*')->with([
                    'usertype' => function ($query) {
                        $query->select('typeid', 'typename');
                    },
                    'businesspartner' => function ($query) {
                        $query->select('bpid', 'bpname');
                    }
                ]);
            }
        ])->findOrFail($id);
    }
}
