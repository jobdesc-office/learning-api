<?php

namespace App\Http\Controllers\api\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\AttendanceServices;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
   public function all(Request $req, AttendanceServices $attendanceServices)
   {
      $whereArr = collect($req->all())->filter();
      $businesspartners = $attendanceServices->getAll($whereArr);
      return response()->json($businesspartners);
   }

   public function store(Request $req, AttendanceServices $attendanceServices)
   {
      $attendanceServices->fill($req->all())->save();
      return response()->json(['message' => \TextMessages::successCreate]);
   }

   public function update($id, Request $req, AttendanceServices $attendanceServices)
   {
      $row = $attendanceServices->findOrFail($id);
      $row->fill($req->all())->save();
      return response()->json(['message' => \TextMessages::successEdit]);
   }
}
