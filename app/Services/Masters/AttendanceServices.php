<?php

namespace App\Services\Masters;

use App\Models\Masters\Attendance;
use App\Models\Masters\Types;
use Auth;
use Carbon\Carbon;
use Doctrine\DBAL\Query;
use Illuminate\Support\Collection;
use App\Models\Masters\Files;
use Illuminate\Support\Facades\DB;

class AttendanceServices extends Attendance
{
   public function getAll(Collection $whereArr)
   {
      $query = $this->getQuery();

      $attwhere = $whereArr->only($this->fillable);
      if ($attwhere->isNotEmpty()) {
         $query = $query->where($attwhere->toArray());
      }

      if ($whereArr->has('datefrom')) {
         $query = $query->whereDate('attdate', '>=', $whereArr->get('datefrom'));
      }

      if ($whereArr->has('dateto')) {
         $query = $query->whereDate('attdate', '<=', $whereArr->get('dateto'));
      }

      return $query->get();
   }

   public function getRecap($start, $end, $startDate, $endDate, $bpid)
   {
      $query = DB::table('msuser')->join('msuserdt', 'msuserdt.userid', 'msuser.userid')->leftJoin('vtattendance', function ($join) use ($startDate, $endDate) {
         $join->on('msuser.userid', '=', 'vtattendance.attuserid');
         if ($startDate != 'null' && $endDate != 'null') {
            $join->whereBetween('vtattendance.attdate', [$startDate, $endDate]);
         }
         if ($startDate != 'null' && $endDate == 'null') {
            $date = Carbon::createFromFormat('Y-m-d', $startDate);
            $month = $date->format('m');
            $year = $date->format('Y');
            $join->whereMonth('vtattendance.attdate', $month)->whereYear('vtattendance.attdate', $year);
         }
      })->leftJoin('mstype', 'mstype.typeid', 'vtattendance.atttype')->where('msuserdt.userdtbpid', '=', $bpid)->where('msuser.isactive', '=', true);

      $typecodes = DB::table('mstype')->select('typeid', 'typecd', 'typedesc')->where('typemasterid', 110)->get();
      $groupedData = $query->get()->groupBy(['userid', 'attdate']);

      $finalData = $groupedData->map(function ($group) use ($typecodes) {
         $attuser = ["userfullname" => $group->first()->first()->userfullname];

         $attendance = [];
         $attendanceSummary = [];
         foreach ($typecodes as $typecode) {
            $attendanceSummary[$typecode->typecd] = 0;
         }

         foreach ($group as $item) {
            $attdate = $item->first()->attdate;
            $attid = $item->first()->attid;
            if ($attdate) {
               $atttypecd = $item->first()->typecd ?? "attpresent";
               $atttypedesc = $item->first()->typedesc ?? "H";
               $clockin = $item->first()->attclockout ? Carbon::createFromFormat('H:i:s', $item->first()->attclockin) : null;
               $clockout = $item->first()->attclockout ? Carbon::createFromFormat('H:i:s', $item->first()->attclockout) : null;
               $attduration = $clockout != null && $clockin != null ? $clockout->diff($clockin)->format('%h:%I:%S') : null;

               $attendanceSummary[$atttypecd]++;

               $attendance[] = [
                  'attid' => $attid,
                  'attdate' => $attdate,
                  'atttypecd' => $atttypecd,
                  'atttypedesc' => $atttypedesc,
                  'attduration' => $attduration,
               ];
            }
         }

         return [
            'attuser' => $attuser,
            'attendance' => $attendance,
            'attsummary' => $attendanceSummary,
         ];
      });
      $totalPage = ceil(($groupedData->count()) / 20);

      $response = [
         'data' => $finalData,
         'typecodes' => $typecodes,
         'totalPages' => $totalPage,
      ];

      return $response;
   }

   public function datatables($id, $startDate, $endDate, $userid)
   {
      $query = $this->getQuery()->select('*', DB::raw('(vtattendance.attclockout - vtattendance.attclockin) AS attduration'), DB::raw("*,concat('" . url() . "', '/images/" . Files::IMAGE_SIZE_MEDIUM_THUMBNAIL . "/', COALESCE(msfiles.directories, 'images/'), '',COALESCE(msfiles.filename, 'no-image.png')) as url"))->leftJoin('msfiles', 'msfiles.refid', 'vtattendance.attid')
         ->where('vtattendance.attbpid', $id)->orderBy('vtattendance.attdate', 'DESC');

      if ($userid != null) {
         $query =  $query->where('vtattendance.attuserid', $userid);
      }
      if ($startDate != null && $endDate != null) {
         $query =  $query->whereBetween('vtattendance.attdate', [$startDate, $endDate]);
      }
      if ($startDate != null && $endDate == null) {
         $query =  $query->where('vtattendance.attdate', $startDate);
      }
      return $query;
   }

   public function getMyAttendanceToday()
   {
      $query = $this->getQuery();
      $date = new Carbon();
      $query = $query->where('attuserid', Auth::user()->userid)->whereDate('attdate', $date->today()->format('Y-m-d'))->get();
      if ($query != null && count($query) > 0) {
         return $query->first();
      }
      return null;
   }

   public function show($attid)
   {
      return DB::table("vtattendance")->select('*', DB::raw("*,concat('" . url() . "', '/images/" . Files::IMAGE_SIZE_MEDIUM . "/', COALESCE(msfiles.directories, 'images/'), '',COALESCE(msfiles.filename, 'no-image.png')) as url"))->leftJoin('msfiles', 'msfiles.refid', 'vtattendance.attid')->where('msfiles.refid', '=', $attid)->limit(1)->get();
   }

   public function getQuery()
   {
      return $this->newQuery()->with([
         'attuser',
         'attbp',
         'atttypes',
      ]);
   }
}
