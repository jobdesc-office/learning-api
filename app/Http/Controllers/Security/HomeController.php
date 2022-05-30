<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\Masters\User;
use App\Models\Masters\Schedule;
use App\Models\Masters\BusinessPartner;
use App\Services\Masters\ScheduleServices;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($id, ScheduleServices $scheduleServices)
    {
        $schedules = $scheduleServices->mySchedules($id);

        return response()->json($schedules);
    }
}
