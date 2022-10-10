<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\AttendanceServices;
use App\Services\Masters\UserServices;
use App\Services\Masters\ActivityCFServices;
use DB;
use DBTypes;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    public function select($id, Request $req, AttendanceServices $userServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $userServices->select($searchValue, $id);

        return response()->json($selects);
    }

    public function datatables($id, Request $req, AttendanceServices $userServices)
    {
        $search = trim(strtolower($req->get('search[value]')));
        $start = $req->get('startdate');
        $end = $req->get('enddate');
        $userid = $req->get('userid');
        $query = $userServices->datatables(
            $id,
            $start,
            $end,
            $userid
        );
        return
            datatables()->eloquent($query)
            ->toJson()
            ->getOriginalContent();
    }

    public function all($id, AttendanceServices $activityService, UserServices $userService)
    {
        $activities = $activityService->getBp($id);
        $employees = $userService->getEmployee($id);
        return response()->json(['activities' => $activities, 'employees' => $employees]);
    }

    public function show($id, AttendanceServices $businessPartnerService, ActivityCFServices $activity)
    {
        $row = $businessPartnerService->find($id);
        $rowcf = $activity->findall($id);
        return response()->json($row);
    }
}
