<?php

namespace App\Services\Masters;

use App\Models\Masters\ScheduleGuest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ScheduleGuestServices extends ScheduleGuest
{
    public function mySchedulesGuest($id)
    {
        $query = $this->newQuery()->select('*')
            ->where('scheuserid', $id)
            ->with([
                'scheuser' => function ($query) {
                    $query->select('userid', 'userfullname');
                },
                'schebp' => function ($query) {
                    $query->select('bpid', 'bpname');
                },
                'schedule' => function ($query) use ($id) {
                    $query->select('*')->with([
                        'schetype' => function ($query) {
                            $query->select('typeid', 'typename');
                        },
                        'schebp' => function ($query) {
                            $query->select('bpid', 'bpname');
                        },
                        'schetoward' => function ($query) {
                            $query->select('userid', 'userfullname');
                        },
                        'schereftype' => function ($query) {
                            $query->select('typeid', 'typename');
                        }
                    ])
                        ->orderBy('schestartdate', 'asc')
                        ->where('scheenddate', null);
                }
            ])
            ->get();

        return $query;
    }
}
