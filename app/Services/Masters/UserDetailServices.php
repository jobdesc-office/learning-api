<?php

namespace App\Services\Masters;

use App\Models\Masters\UserDetail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserDetailServices extends UserDetail
{

    public function prospectowner($searchValue)
    {
        return $this->newQuery()->select('*')
            ->with([
                'user' => function ($query) {
                    $query->select('userid', 'userfullname');
                },
                'usertype' => function ($query) {
                    $query->select('typeid', 'typename');
                },
                'businesspartner' => function ($query) {
                    $query->select('bpid', 'bpname', 'bpphone', 'bpemail')->with(['bptype']);
                },
            ])
            ->where(function ($query) use ($searchValue) {
                $query->where(DB::raw('TRIM(LOWER(userfullname))'), 'like', "%$searchValue%");
                // ->orWhereHas('usertype', function ($query) use ($searchValue) {
                //     $query->where(DB::raw('TRIM(LOWER(userfullname))'), 'like', "%$searchValue%");
                // });
            })
            ->get();
    }

    public function find($id)
    {
        return $this->newQuery()
            ->with([
                'usertype' => function ($query) {
                    $query->select('typeid', 'typename');
                },
                'businesspartner' => function ($query) {
                    $query->select('bpid', 'bpname', 'bpphone', 'bpemail', 'bptypeid')->with(['bptype']);
                },
                'user' => function ($query) {
                    $query->select('*');
                }
            ])
            ->findOrFail($id);
    }

    public function getAll(Collection $whereArr)
    {
        $users = $this->newQuery()->with([
            'usertype' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'businesspartner' => function ($query) {
                $query->select('bpid', 'bpname', 'bpphone', 'bpemail', 'bptypeid')->with(['bptype']);
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
