<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Services\Masters\ScheduleServices;
use App\Services\Masters\ScheduleGuestServices;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($id, ScheduleServices $scheduleServices, ScheduleGuestServices $scheduleGuestServices)
    {
        $schedules = $scheduleServices->mySchedules($id);
        $scheduleGuest = $scheduleGuestServices->mySchedulesGuest($id);

        return response()->json(['mySchedules' => $schedules, 'mySchedulesGuest' => $scheduleGuest]);
    }
}
