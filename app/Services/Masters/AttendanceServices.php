<?php

namespace App\Services\Masters;

use App\Models\Masters\Attendance;
use App\Models\Masters\Types;
use Auth;
use Carbon\Carbon;
use Doctrine\DBAL\Query;
use Illuminate\Support\Collection;
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

   public function getRecap($start, $end, $startDate, $endDate, $isExport)
   {
      $query = DB::table('msuser')->leftJoin('vtattendance', 'msuser.userid', '=', 'vtattendance.attuserid')->leftJoin('mstype', 'mstype.typeid', 'vtattendance.atttype');
      if ($startDate != 'null' && $endDate != 'null') {
         $query =  $query->whereBetween('vtattendance.attdate', [$startDate, $endDate]);
      }
      if ($startDate != 'null' && $endDate == 'null') {
         $date = Carbon::createFromFormat('Y-m-d', $startDate);
         $month = $date->format('m');
         $year = $date->format('Y');
         $query =  $query->whereMonth('vtattendance.attdate', $month)->whereYear('vtattendance.attdate', $year);
      }

      $typecodes = DB::table('mstype')->select('typeid', 'typecd', 'typedesc')->where('typemasterid', 110)->get();
      $groupedData = $query->get()->groupBy(['attuserid', 'attdate']);

      $finalData = $groupedData->map(function ($group) use ($typecodes) {
         $attuser = ["userfullname" => $group->first()->first()->userfullname];
         $attendance = [];
         $attendanceSummary = [];
         foreach ($typecodes as $typecode) {
            $attendanceSummary[$typecode->typecd] = 0;
         }

         foreach ($group as $item) {
            $attdate = $item->first()->attdate;
            $atttypecd = $item->first()->typecd ?? "attpresent";
            $atttypedesc = $item->first()->typedesc ?? "H";
            $clockin = Carbon::createFromFormat('H:i:s', $item->first()->attclockin);
            $clockout = $item->first()->attclockout ? Carbon::createFromFormat('H:i:s', $item->first()->attclockout) : null;
            $attduration = $clockout != null ? $clockout->diff($clockin)->format('%h:%I:%S') : null;

            $attendanceSummary[$atttypecd]++;

            $attendance[] = [
               'attdate' => $attdate,
               'atttypecd' => $atttypecd,
               'atttypedesc' => $atttypedesc,
               'attduration' => $attduration,
            ];
         }

         return [
            'attuser' => $attuser,
            'attendance' => $attendance,
            'attsummary' => $attendanceSummary,
         ];
      });

      $totalCount = $query->count();
      $offset = $start == 0 ? $start : max($start + 1, 0);
      $limit = $start == 0 ? min($end - $start + 1, $totalCount - $offset) : min($end - $start, $totalCount - $offset);

      $isLastPage = ($offset + $limit) >= $totalCount;
      $totalPage = ceil(($groupedData->count()) / 10);

      $response = [
         'data' => $finalData,
         'isLastPage' => $isLastPage,
         'typecodes' => $typecodes,
         'totalPages' => $totalPage,
      ];

      return $response;
   }

   public function datatables($id, $startDate, $endDate, $userid)
   {
      $query = $this->getQuery()->select('*', DB::raw('(attclockout - attclockin) AS attduration'))
         ->where('attbpid', $id)->orderBy('attdate', 'DESC');
      if ($userid != null) {
         $query =  $query->where('attuserid', $userid);
      }
      if ($startDate != null && $endDate != null) {
         $query =  $query->whereBetween('attdate', [$startDate, $endDate]);
      }
      if ($startDate != null && $endDate == null) {
         $query =  $query->where('attdate', $startDate);
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

   public function getQuery()
   {
      return $this->newQuery()->with([
         'attuser',
         'attbp',
         'atttypes',
      ]);
   }
}
