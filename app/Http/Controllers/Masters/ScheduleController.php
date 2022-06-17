<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Schedule;
use App\Models\Masters\ScheduleGuest;
use App\Services\Masters\ScheduleServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function all(Request $req, ScheduleServices $scheduleServices)
    {
        $schedules = $scheduleServices->getAll(collect($req->all()));
        return response()->json($schedules);
    }

    public function store(Request $req, Schedule $scheduleModel, ScheduleGuest $scheduleGuestModel)
    {
        $insert = collect($req->only($scheduleModel->getFillable()))->filter()->except('updatedby');

        $scheduleModel->fill($insert->toArray())->save();

        if ($req->has('members') && $req->get('members') != null) {
            $members = json_decode($req->get('members'));
            foreach ($members as $member) {
                $scheduleGuestModel->create([
                    'scheid' => $scheduleModel->scheid,
                    'scheuserid' => $member->scheuserid,
                    'schebpid' => $member->schebpid,
                    'schepermisid' => $member->schepermisid
                ]);
            }
        }

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ScheduleServices $scheduleServices)
    {
        $schedule = $scheduleServices->find($id);
        return response()->json($schedule);
    }

    public function update($id, Request $req, Schedule $scheduleModel, ScheduleGuest $scheduleGuestModel)
    {
        $schedule = $scheduleModel->findOrFail($id);

        $fields = collect($req->only($scheduleModel->getFillable()))->filter()
            ->except('createdby');
        $schedule->update($fields->toArray());

        $members = json_decode($req->get('members'));
        if ($members) {
            $scheduleGuestModel->where('scheid', $id)->delete();
            foreach ($members as $member) {
                $scheduleGuestModel->create([
                    'scheid' => $id,
                    'scheuserid' => $member->scheuserid,
                    'schebpid' => $member->schebpid,
                    'schepermisid' => $member->schepermisid,
                ]);
            }
        }

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, Schedule $scheduleModel, ScheduleGuest $scheduleGuest)
    {
        DB::beginTransaction();
        try {
            $scheduleGuest->select('scheid')->where('scheid', $id)->delete();
            $scheduleModel->findOrFail($id)->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
