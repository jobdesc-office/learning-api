<?php

namespace App\Http\Controllers\api\Masters;

use App\Collections\Files\FileUploader;
use App\Http\Controllers\Controller;
use App\Models\Masters\AttendanceLocation;
use App\Services\Masters\AttendanceServices;
use DBTypes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

   public function store2(Request $req, AttendanceServices $attendanceServices, AttendanceLocation $attendanceLocation)
   {
       try {

           $typecd = $req->atttypecd;

           $typeid = find_type()->in([$typecd])->get($typecd)->getId();

           $att = $attendanceServices->create([
               'attbpid' => $req->attbpid,
               'attuserid' => $req->attuserid,
               'attdate' => $req->attdate,
               'createdby' => $req->attuserid,
               'updatedby' => $req->attuserid,
               'atttype' => $typeid,
           ]);

           $type = find_type()->in([DBTypes::attendancefile])->get(DBTypes::attendancefile)->getId();

           try {
               $file = $req->file("image");
               $temp_path = $file->getPathname();
               $filename = Str::replace(['/', '\\'], '', Hash::make(Str::random())) . '.' . $file->getClientOriginalExtension();

               $file = new FileUploader($temp_path, $filename, 'images/', $type, $att->attid);
               $file->upload();
           } catch (Exception $e) {
               throw new Exception($e->getMessage(), $e->getCode());
           }

           return $this->jsonSuccess(\TextMessages::successCreate);
       } catch (\Exception $exception) {
           return $this->jsonError($exception);
       }
   }

   public function update($id, Request $req, AttendanceServices $attendanceServices, AttendanceLocation $attendanceLocation)
   {
       $attlocs = $attendanceLocation->withJoin($attendanceLocation->defaultSelects)
           ->where('aluserid', $req->attuserid)
           ->get();

       $typecd = \DBTypes::attendancePresent;
       foreach ($attlocs as $attloc) {
           $distance = distance($attloc->allatitude, $attloc->allongitude, $req->attlatout, $req->attlongout, "K") * 1000;
           if ($distance > 200) {
               $typecd = \DBTypes::attendanceOutOfLocation;
           } else {
               $typecd = \DBTypes::attendancePresent;
               break;
           }
       }

       $typeid = find_type()->in([$typecd])->get($typecd)->getId();
       $typeidOFL = find_type()->in([\DBTypes::attendanceOutOfLocation])->get(\DBTypes::attendanceOutOfLocation)->getId();

       $row = $attendanceServices->findOrFail($id);

       if ($row->atttype == $typeidOFL) {
           $row->update([
               'attlatout' => $req->attlatout,
               'attlongout' => $req->attlongout,
               'attclockout' => $req->attclockout,
               'attaddressout' => $req->attaddressout,
           ]);
       } else {
           $row->update([
               'attlatout' => $req->attlatout,
               'attlongout' => $req->attlongout,
               'attclockout' => $req->attclockout,
               'attaddressout' => $req->attaddressout,
               'atttype' => $typeid,
           ]);
       }

       return response()->json(['message' => \TextMessages::successEdit]);
   }
}
