<?php

namespace App\Http\Controllers;

use App\Models\Masters\User;
use App\Models\Masters\Schedule;
use App\Models\Masters\BusinessPartner;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::all();
        $schedules = Schedule::all();
        $partners = BusinessPartner::all();

        return response()->json(['users' => $users, 'schedules' => $schedules, 'businesspartner' => $partners]);
    }
}
