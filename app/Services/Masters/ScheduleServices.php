<?php

namespace App\Services\Masters;

use App\Models\Masters\Schedule;
use Illuminate\Support\Collection;

class ScheduleServices extends Schedule
{
    public function mySchedules($id)
    {
        $query = $this->newQuery()->select('*')
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
            ])
            ->where('scheenddate', null)
            ->where('schetowardid', $id)
            ->get();

        return $query;
    }

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

    public function getAll(Collection $whereArr)
    {
        $query = $this->newQuery()
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
            ]);

        $scheduleWhere = $whereArr->only($this->fillable);
        if ($scheduleWhere->isNotEmpty()) {
            $query = $query->where($scheduleWhere->toArray());
        }

        if ($whereArr->has('schemonth')) {
            $query = $query->where(function ($q) use ($whereArr) {
                $q->WhereMonth('schestartdate', $whereArr->get('schemonth'))
                    ->orWhereMonth('scheenddate', $whereArr->get('schemonth'));
            });
        }

        if ($whereArr->has('schedate')) {
            $query = $query->where(function ($q) use ($whereArr) {
                $q->where(function ($q) use ($whereArr) {
                    $q->whereDate("schestartdate", "<=", $whereArr->get('schedate'))
                        ->whereDate("scheenddate", ">=", $whereArr->get('schedate'));
                });
                $q->orWhere(function ($q) use ($whereArr) {
                    $q->whereDate("schestartdate", $whereArr->get('schedate'))->where("scheenddate", null);
                });
            });
        }
        return $query->get();
    }
}
