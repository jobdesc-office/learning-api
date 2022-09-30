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
      $insert = collect($req->only($attendanceServices->getFillable()))->filter()
         ->except('updatedby');

      $attendanceServices->create($insert->toArray());

      return response()->json(['message' => \TextMessages::successCreate]);
   }

   public function update($id, Request $req, AttendanceServices $attendanceServices)
   {
      $row = $attendanceServices->findOrFail($id);
      $update = collect($req->only($attendanceServices->getFillable()))->filter()
         ->except('createdby');
      $row->update($update->toArray());

      return response()->json(['message' => \TextMessages::successEdit]);
   }
}
