<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Attendance;
use App\Services\Masters\AttendanceServices;
use App\Services\Masters\UserServices;
use App\Services\Masters\ActivityCFServices;
use DB;
use DBTypes;
use App\Http\Controllers\Masters\ExportData;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

class AttendanceController extends Controller
{

    public function select($id, Request $req, AttendanceServices $userServices)
    {
        $searchValue = trim(strtolower($req->get('searchValue')));
        $selects = $userServices->select($searchValue, $id);

        return response()->json($selects);
    }

    public function calendar(Request $req, AttendanceServices $attendanceServices)
    {
        $data = $attendanceServices->getMonth($req->get('start'), $req->get('end'), $req->get('startdate'), $req->get('enddate'), false);

        return response()->json($data);
    }

    public function exportCalendar(AttendanceServices $attendanceServices, Request $req)
    {
        $startDate = $req->get('startdate');
        $endDate = $req->get('enddate');
        $data = $attendanceServices->getMonth($req->get('start'), $req->get('end'), $startDate, $endDate, true);
        $fileName = 'attendance-' . $startDate . '-' . $endDate . '.xlsx';

        $exportData = new ExportData($data['data'], $startDate, $endDate, $data['typenames']);

        $filePath = '/files/' . $fileName;

        Excel::store($exportData, $filePath, 'public');

        $fileUrl = url('storage') . $filePath;

        return response()->json([
            'filename' => $fileName,
            'file_url' => $fileUrl
        ]);
    }

    public function removeCalendar(Request $req)
    {
        $filename = $req->get('filename');
        unlink(storage_path('app/public/files/' . $filename));
    }

    public function datatables($id, Request $req, AttendanceServices $userServices)
    {
        $search = trim(strtolower($req->get('search[value]')));
        $start = $req->get('startdate');
        $end = $req->get('enddate');
        $userid = $req->get('userid');
        $query = $userServices->datatables(
            $id,
            $start,
            $end,
            $userid
        );
        return
            datatables()->eloquent($query)
            ->toJson()
            ->getOriginalContent();
    }

    public function all($id, AttendanceServices $activityService, UserServices $userService)
    {
        $activities = $activityService->getBp($id);
        $employees = $userService->getEmployee($id);
        return response()->json(['activities' => $activities, 'employees' => $employees]);
    }

    public function show($id, AttendanceServices $businessPartnerService, ActivityCFServices $activity)
    {
        $row = $businessPartnerService->find($id);
        $rowcf = $activity->findall($id);
        return response()->json($row);
    }
}
