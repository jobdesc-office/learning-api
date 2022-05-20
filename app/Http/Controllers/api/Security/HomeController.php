<?php

namespace App\Http\Controllers\api\security;

use App\Http\Controllers\Controller;
use App\Models\Masters\User;
use App\Models\Masters\Schedule;
use App\Models\Masters\BusinessPartner;
use App\Services\Masters\ScheduleServices;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::all()->where('isactive', true)->count();
        $schedules = Schedule::all()->where('isactive', true)->count();
        $partners = BusinessPartner::all()->where('isactive', true)->count();

        return response()->json(['users' => $users, 'schedules' => $schedules, 'businesspartner' => $partners]);
    }
}
