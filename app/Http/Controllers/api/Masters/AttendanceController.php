<?php

namespace App\Http\Controllers\api\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\AttendanceLocation;
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

   public function store(Request $req, AttendanceServices $attendanceServices, AttendanceLocation $attendanceLocation)
   {
       try {
           $attlocs = $attendanceLocation->withJoin($attendanceLocation->defaultSelects)
               ->where('aluserid', $req->attuserid)
               ->get();

           $typecd = \DBTypes::attendancePresent;
           foreach ($attlocs as $attloc) {
               $distance = distance($attloc->allatitude, $attloc->allongitude, $req->attlatin, $req->attlongin, "K") * 1000;
               if ($distance > 200) {
                   $typecd = \DBTypes::attendanceOutOfLocation;
               } else {
                   $typecd = \DBTypes::attendancePresent;
                   break;
               }
           }

           $typeid = find_type()->in([$typecd])->get($typecd)->getId();

           $attendanceServices->create([
               'attbpid' => $req->attbpid,
               'attuserid' => $req->attuserid,
               'attdate' => $req->attdate,
               'attclockin' => $req->attclockin,
               'attclockout' => $req->attclockout,
               'attlatin' => $req->attlatin,
               'attlongin' => $req->attlongin,
               'attaddressin' => $req->attaddressin,
               'attlatout' => $req->attlatout,
               'attlongout' => $req->attlongout,
               'attaddressout' => $req->attaddressout,
               'createdby' => $req->attuserid,
               'updatedby' => $req->attuserid,
               'atttype' => $typeid,
           ]);

           return response()->json(['message' => \TextMessages::successCreate]);
       } catch (\Exception $exception) {
           return response()->json(['message' => $exception->getMessage()]);
       }
   }

   public function update($id, Request $req, AttendanceServices $attendanceServices)
   {
      $row = $attendanceServices->findOrFail($id);
      $row->fill($req->all())->save();
      return response()->json(['message' => \TextMessages::successEdit]);
   }
}
