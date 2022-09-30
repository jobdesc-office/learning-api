<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Services\Masters\ScheduleServices;
use App\Services\Masters\ScheduleGuestServices;
use App\Services\Masters\DspByBpService;
use App\Services\Masters\DspByCustLabelService;
use App\Services\Masters\DspByCustLabelDtService;
use App\Services\Masters\DspByCustService;
use App\Services\Masters\DspByOwnerService;
use App\Services\Masters\DspByStageService;
use App\Services\Masters\DspByStageDtService;
use App\Services\Masters\DspByStatusService;
use App\Services\Masters\DspByStatusDtService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($id, ScheduleServices $scheduleServices, ScheduleGuestServices $scheduleGuestServices)
    {
        $schedules = $scheduleServices->mySchedules($id);
        $scheduleGuest = $scheduleGuestServices->mySchedulesGuest($id);

        return response()->json(['mySchedules' => $schedules, 'mySchedulesGuest' => $scheduleGuest]);
    }

    public function reportByCust($id, Request $request, DspByCustService $service)
    {
        $order = $request->header('order') ?? 'desc';
        $data = collect($request->all())->filter();
        return response()->json($service->getReportByBp($id, $data, $order));
    }

    public function reportByStage($id, Request $request, DspByStageDtService $service)
    {
        $data = collect($request->all())->filter();
        return response()->json($service->getReportByBp($id, $data));
    }

    public function reportByStatus($id, Request $request, DspByStatusDtService $service)
    {
        $data = collect($request->all())->filter();
        return response()->json($service->getReportByBp($id, $data));
    }

    public function reportByCustLabel($id, Request $request, DspByCustLabelDtService $service)
    {
        $data = collect($request->all())->filter();
        return response()->json($service->getReportByBp($id, $data));
    }

    public function reportByOwner($id, Request $request, DspByOwnerService $service)
    {
        $data = collect($request->all())->filter();
        return response()->json($service->getReportByBp($id, $data));
    }

    public function reportYears($id, Request $request, DspByBpService $service)
    {
        return response()->json($service->getReportYearByBp($id)->map(function ($item) {
            $item = intval($item);
            return $item;
        }));
    }
}
