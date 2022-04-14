<?php

namespace App\Services\Masters;

use App\Models\Masters\Schedule;

class ScheduleServices extends Schedule
{
    public function find($id)
    {
        return $this->newQuery()
            ->with([
                'schetype' => function ($query) {
                    $query->select('typeid', 'typename');
                },
                'scheguest' => function ($query) {
                    $query->select('*')
                        ->join('msuser', 'vtscheduleguest.scheuserid', '=', 'msuser.userid');
                },
                'schebp' => function ($query) {
                    $query->select('bpid', 'bpname');
                },
                'schetoward' => function ($query) {
                    $query->select('userid', 'userfullname');
                }
            ])
            ->findOrFail($id);
    }

    public function datatables()
    {
        return $this->newQuery()->select('*')
            ->with([
                'schetype' => function ($query) {
                    $query->select('typeid', 'typename');
                },
                'schebp' => function ($query) {
                    $query->select('bpid', 'bpname');
                },
                'schetoward' => function ($query) {
                    $query->select('userid', 'userfullname');
                }
            ]);
    }
}
