<?php

namespace App\Services\Masters;

use App\Models\Masters\Schedule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ScheduleServices extends Schedule
{
    public function mySchedules($id)
    {
        $query = $this->newQuery()->select('*')
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
                },
                'schereftype' => function ($query) {
                    $query->select('typeid', 'typename');
                }
            ])
            ->orderBy('schestartdate', 'asc')
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
                    $query->with('scheuser', 'schebp');
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
            ->findOrFail($id);
    }

    public function datatables($order, $orderby, $search)
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
            ])
            ->where(function ($query) use ($search, $order) {
                $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
            })
            ->orderBy($order, $orderby);
    }

    public function filterSchedule(Collection $whereArr)
    {
        $query = $this->newQuery()
            ->with([
                'schetype' => function ($query) {
                    $query->select('typeid', 'typename');
                },
                'scheguest' => function ($query) {
                    $query->with('scheuser', 'schebp');
                },
                'schebp' => function ($query) {
                    $query->select('bpid', 'bpname');
                },
                'schetoward' => function ($query) {
                    $query->select('userid', 'userfullname');
                }
            ]);

        $scheduleWhere = $whereArr->only($this->getFillable());
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

        if ($whereArr->has('startdate') && $whereArr->has('enddate')) {
            $startDate = $whereArr->get('startdate');
            $endDate = $whereArr->get('enddate');
            $query = $query->where(DB::raw("get_schedule_from_dates(schestartdate, scheenddate, '$startDate', '$endDate')"), "true");
        }
        return $query;
    }

    public function getAll(Collection $whereArr)
    {
        return $this->filterSchedule($whereArr)->get();
    }

    public function countAll(Collection $whereArr)
    {
        return $this->filterSchedule($whereArr)->count();
    }
}
