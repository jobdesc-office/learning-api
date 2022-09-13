<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\DspByCustLabelService;
use App\Services\Masters\DspByCustService;
use App\Services\Masters\DspByStageService;
use App\Services\Masters\DspByStatusService;
use Illuminate\Http\Request;

class InsightController extends Controller
{
   public function reportByCust($id, Request $request, DspByCustService $service)
   {
      $data = collect($request->all())->filter();
      return response()->json($service->getReportByBp($id, $data));
   }

   public function reportByCustYears($id, Request $request, DspByCustService $service)
   {
      return response()->json($service->getReportYearByBp($id));
   }

   public function reportByStage($id, Request $request, DspByStageService $service)
   {
      $data = collect($request->all())->filter();
      return response()->json($service->getReportByBp($id, $data));
   }

   public function reportByStageYears($id, Request $request, DspByStageService $service)
   {
      return response()->json($service->getReportYearByBp($id));
   }

   public function reportByStatus($id, Request $request, DspByStatusService $service)
   {
      $data = collect($request->all())->filter();
      return response()->json($service->getReportByBp($id, $data));
   }

   public function reportByStatusYears($id, Request $request, DspByStatusService $service)
   {
      return response()->json($service->getReportYearByBp($id));
   }

   public function reportByCustLabel($id, Request $request, DspByCustLabelService $service)
   {
      $data = collect($request->all())->filter();
      return response()->json($service->getReportByBp($id, $data));
   }

   public function reportByCustLabelYears($id, Request $request, DspByCustLabelService $service)
   {
      return response()->json($service->getReportYearByBp($id));
   }
}
