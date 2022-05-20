<?php

namespace App\Http\Controllers\api\security;

use App\Http\Controllers\Controller;
use App\Services\Masters\ScheduleServices;
use App\Services\Masters\UserDetailServices;

class ProfileController extends Controller
{
    public function index($id, ScheduleServices $scheduleServices, UserDetailServices $userDetailServices)
    {
        $mySchedules = $scheduleServices->mySchedules($id);

        return response()->json($mySchedules);
    }
}
