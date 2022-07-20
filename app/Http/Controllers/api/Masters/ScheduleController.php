<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\ProspectActivity;
use App\Models\Masters\Schedule;
use App\Models\Masters\ScheduleGuest;
use App\Services\Masters\ScheduleServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TextMessages;

class ScheduleController extends Controller
{
    public function all(Request $req, ScheduleServices $scheduleServices)
    {
        $schedules = $scheduleServices->getAll(collect($req->all()));
        return response()->json($schedules);
    }

    public function store(Request $req, Schedule $scheduleModel, ScheduleGuest $scheduleGuestModel)
    {
        $insert = collect($req->only($scheduleModel->getFillable()))->filter();

        $result = $scheduleModel->fill($insert->toArray())->save();

        if ($result) {

            if ($req->has('members') && $req->get('members') != null) {
                $members = json_decode($req->get('members'));
                $guestsData = collect([]);
                foreach ($members as $member) {
                    $guestsData->push([
                        'scheid' => $scheduleModel->scheid,
                        'scheuserid' => $member->scheuserid,
                        'schebpid' => $member->schebpid,
                        'schepermisid' => $member->schepermisid
                    ]);
                }
                $scheduleGuestModel->create($guestsData->toArray());
            }

            return response()->json($scheduleModel->toArray());
        }
        return response(TextMessages::failedCreate, 400);
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

        if ($req->has('members') && $req->get('members') != null) {
            $scheduleGuestModel->where('scheid', $id);

            $members = json_decode($req->get('members'));
            foreach ($members as $member) {
                $scheduleGuestModel->update([
                    'scheid' => $scheduleModel->scheid,
                    'scheuserid' => $member->scheuserid,
                    'schebpid' => $member->schebpid,
                    'schepermisid' => $member->schepermisid
                ]);
            }
        }

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, Schedule $scheduleModel, ScheduleGuest $scheduleGuest, ProspectActivity $prospectActivity)
    {
        DB::beginTransaction();
        try {
            $scheduleGuest->select('scheid')->where('scheid', $id)->delete();
            $scheduleModel->find($id);

            if ($scheduleModel->scherefid != null) {
                $prospectActivityData = $prospectActivity->find($scheduleModel->scherefid);
                if ($prospectActivityData != null) {
                    $prospectActivityData->delete();
                }
            }

            $scheduleModel->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function scheduleCount(Request $req, ScheduleServices $scheduleServices,  ProspectActivity $prospectActivity)
    {
        $schedules = $scheduleServices->countAll(collect($req->all()));
        return response()->json(['count' => $schedules]);
    }
}
