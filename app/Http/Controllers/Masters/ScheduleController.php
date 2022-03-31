<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Schedule;
use App\Services\Masters\ScheduleServices;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function all(ScheduleServices $scheduleServices)
    {
        $schedules = $scheduleServices->all();
        return response()->json($schedules);
    }

    public function datatables(ScheduleServices $scheduleServices)
    {
        $query = $scheduleServices->datatables();

        return datatables()->eloquent($query)
            ->toJson();
    }

    public function store(Request $req, Schedule $scheduleModel)
    {
        $insert = collect($req->only($scheduleModel->getFillable()))->filter();

        $scheduleModel->fill($insert->toArray())->save();

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ScheduleServices $scheduleServices)
    {
        $schedule = $scheduleServices->find($id);
        return response()->json($schedule);
    }

    public function update($id, Request $req, Schedule $scheduleModel)
    {
        $schedule = $scheduleModel->findOrFail($id);

        $fields = collect($req->only($scheduleModel->getFillable()))->filter()
            ->except('updatedby');
        $schedule->fill($fields)->save();

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, Schedule $scheduleModel)
    {
        $row = $scheduleModel->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
