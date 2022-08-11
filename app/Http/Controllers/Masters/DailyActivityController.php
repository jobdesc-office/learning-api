<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\DailyActivityServices;
use App\Services\Masters\UserServices;
use DB;
use DBTypes;
use Illuminate\Http\Request;

class DailyActivityController extends Controller
{

    public function datatables($id, DailyActivityServices $userServices)
    {
        $query = $userServices->datatables($id);
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

    public function show($id, DailyActivityServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }
}
