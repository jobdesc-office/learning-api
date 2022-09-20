<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\DailyActivity;
use App\Models\Masters\Prospect;
use App\Services\Masters\ActivityCustomFieldService;
use App\Services\Masters\DailyActivityServices;
use App\Services\Masters\FilesServices;
use App\Services\Masters\TrHistoryServices;
use DB;
use DBTypes;
use Illuminate\Http\Request;

class DailyActivityController extends Controller
{

    public function all(Request $req, DailyActivityServices $activityService)
    {
        $whereArr = collect($req->all())->filter();
        $activity = $activityService->getAll($whereArr);
        return response()->json($activity);
    }

    public function store(Request $req, DailyActivityServices $activityServices)
    {
        if ($req->has('activities')) {
            $activityServices->addAll(collect($req->all())->filter());
        }
        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, DailyActivityServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, DailyActivityServices $activityServices)
    {
        $update = collect($req->all())->filter()
            ->except('createdby');
        if ($req->hasFile('dayactpics')) {
            $update->put('dayactpics', $req->file('dayactpics'));
        }

        $activityServices->edit($id, $update);

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, DailyActivityServices $activityServices, FilesServices $filesServices)
    {
        DB::beginTransaction();
        try {
            $activity = $activityServices->find($id);

            // delete file
            $comptpic = find_type()->in([DBTypes::dailyactivitypics])->get(DBTypes::dailyactivitypics)->getId();
            $files = $filesServices->where('refid', $id)->where('transtypeid', $comptpic)->get();
            foreach ($files as $file) {
                $file->delete();
            }
            $activity->delete();

            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
        return response()->json(['message' => \TextMessages::successDelete], 400);
    }

    public function dailyActivityCount(Request $req, DailyActivityServices $activityServices)
    {
        $activitys = $activityServices->countAll(collect($req->all()));
        return response()->json(['count' => $activitys]);
    }

    public function dailyActivityHistories(Request $request, TrHistoryServices $trHistoryServices, DailyActivity $dailyActivity)
    {
        return $trHistoryServices->findHistories($request->get('dayactid'), $dailyActivity->getTable(), $request->get('bpid'));
    }

    public function dailyActivityCustomField(Request $request, ActivityCustomFieldService $service)
    {
        return response()->json($service->getAll(collect($request->all())->filter()));
    }
}
