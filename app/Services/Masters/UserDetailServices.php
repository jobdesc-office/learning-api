<?php

namespace App\Services\Masters;

use App\Models\Masters\UserDetail;

class UserDetailServices extends UserDetail
{
    public function find($id)
    {
        return $this->newQuery()
            // ->join('msuser', 'msuserdt.userid', '=', 'msuser.userid')
            // ->join('mstype', 'msuserdt.userdttypeid', '=', 'mstype.typeid')
            // ->join('msbusinesspartner', 'msuserdt.userdtbpid', '=', 'msbusinesspartner.bpid')
            ->with([
                'usertype' => function ($query) {
                    $query->select('typeid', 'typename');
                },
                'businesspartner' => function ($query) {
                    $query->select('bpid', 'bpname');
                },
                'user' => function ($query) {
                    $query->select('*');
                }
            ])
            // ->where('userid', $id)
            // ->get();
            ->findOrFail($id);
    }

    public function getAll($whereArr)
    {
        $users = $this->newQuery()->with([
            'usertype' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'businesspartner' => function ($query) {
                $query->select('bpid', 'bpname');
            },
            'user' => function ($query) {
                $query->select('*');
            }
        ]);
        if (!$whereArr->only($this->getFillable())->isEmpty()) {
            $users = $users->where($whereArr->only($this->getFillable())->toArray());
        }
        return $users->get();
    }
}
