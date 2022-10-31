<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\DailyActivityServices;
use App\Services\Masters\UserServices;
use App\Services\Masters\ActivityCFServices;
use DB;
use DBTypes;
use Illuminate\Http\Request;

class DailyActivityController extends Controller
{

    public function select($id, Request $req, DailyActivityServices $userServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $userServices->select($searchValue, $id);

        return response()->json($selects);
    }

    public function datatables($id, Request $req, DailyActivityServices $userServices)
    {
        $start = $req->get('startdate');
        $end = $req->get('enddate');
        $categoryid = $req->get('categoryid');

        $query = $userServices->datatables(
            $id,
            $start,
            $end,
            $categoryid
        );
        return
            datatables()->eloquent($query)
            ->toJson()
            ->getOriginalContent();
    }

    public function all($id, DailyActivityServices $activityService, UserServices $userService)
    {
        $activities = $activityService->getBp($id);
        $employees = $userService->getEmployee($id);
        return response()->json(['activities' => $activities, 'employees' => $employees]);
    }

    public function show($id, DailyActivityServices $businessPartnerService, ActivityCFServices $activity)
    {
        $row = $businessPartnerService->find($id);
        $rowcf = $activity->findall($id);
        return response()->json($row);
    }
}
