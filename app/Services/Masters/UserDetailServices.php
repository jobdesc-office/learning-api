<?php

namespace App\Services\Masters;

use App\Models\Masters\UserDetail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    public function getAll(Collection $whereArr)
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
        if ($whereArr->has('search')) {
            $users = $users->whereHas('user', function ($query) use ($whereArr) {
                $searchValue = strtolower($whereArr->get('search'));
                $query->where(DB::raw('TRIM(LOWER(userfullname))'), 'like', "%$searchValue%");
            });
        }
        return $users->get();
    }
}
