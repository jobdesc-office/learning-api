<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\Masters\User;
use App\Models\Masters\Schedule;
use App\Models\Masters\BusinessPartner;
use App\Services\Masters\ScheduleServices;

class HomeController extends Controller
{
    public function index($id, ScheduleServices $scheduleServices)
    {
        $users = User::all()->where('isactive', true)->count();
        $schedules = Schedule::all()->where('isactive', true)->count();
        $partners = BusinessPartner::all()->where('isactive', true)->count();

        $mySchedules = $scheduleServices->mySchedules($id);

        return response()->json(['users' => $users, 'schedules' => $schedules, 'businesspartner' => $partners, 'mySchedules' => $mySchedules]);
    }
}
