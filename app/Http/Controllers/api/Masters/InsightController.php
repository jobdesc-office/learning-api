<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\DspByOwner;
use App\Services\Masters\DspByBpService;
use App\Services\Masters\DspByCustLabelService;
use App\Services\Masters\DspByCustService;
use App\Services\Masters\DspByOwnerService;
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

   public function reportByStage($id, Request $request, DspByStageService $service)
   {
      $data = collect($request->all())->filter();
      return response()->json($service->getReportByBp($id, $data));
   }

   public function reportByStatus($id, Request $request, DspByStatusService $service)
   {
      $data = collect($request->all())->filter();
      return response()->json($service->getReportByBp($id, $data));
   }

   public function reportByCustLabel($id, Request $request, DspByCustLabelService $service)
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
