<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Schedule;
use App\Models\Masters\ScheduleGuest;
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

    public function store(Request $req, Schedule $scheduleModel, ScheduleGuest $scheduleGuestModel)
    {
        $insert = collect($req->only($scheduleModel->getFillable()))->filter();

        $scheduleModel->fill($insert->toArray())->save();

        $members = json_decode($req->get('members'));
        foreach ($members as $member) {
            $scheduleGuestModel->create([
                'scheid' => $scheduleModel->scheid,
                'scheuserid' => $member->scheuserid,
                'schebpid' => $member->schebpid,
                'schepermisid' => $member->schepermisid
            ]);
        }

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
            ->except('createdby');
        $schedule->update($fields->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, Schedule $scheduleModel)
    {
        $row = $scheduleModel->findOrFail($id);
        $row->delete();

        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
