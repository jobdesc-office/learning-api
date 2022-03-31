<?php

namespace App\Services\Masters;

use App\Models\Masters\Schedule;

class ScheduleServices extends Schedule
{
    public function find($id)
    {
        return $this->newQuery()->with([
            'schetypeid' => function ($query) {
                $query->select('typeid', 'typename');
            },
            'schereftypeid' => function ($query) {
                $query->select('typeid', 'typename');
            }
        ])
            ->findOrFail($id);
    }
}
