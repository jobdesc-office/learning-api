<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\DailyActivityServices;
use App\Services\Masters\FilesServices;
use DB;
use DBTypes;
use Illuminate\Http\Request;

class DailyActivityController extends Controller
{

    public function all($id, DailyActivityServices $activityService)
    {
        $activity = $activityService->getBp($id);
        return response()->json($activity);
    }

    public function show($id, DailyActivityServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }
}
