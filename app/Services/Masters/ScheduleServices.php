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
            'schereftypeid' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'businesspartner' => function ($query) {
                $query->select('bpid', 'bpname');
            },
            'user' => function ($query) {
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
            'businesspartner' => function ($query) {
                $query->select('bpid', 'bpname');
            },
            'user' => function ($query) {
                $query->select('userid', 'userfullname');
            }
        ]);
    }
}
