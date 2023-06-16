<?php

namespace App\Services\Masters;

use App\Models\Masters\Attendance;
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

   public function getMonth($start, $end, $startDate, $endDate, $isExport)
   {
      $query = $this->getQuery()->with(['atttypes']);
      if ($startDate != 'null' && $endDate != 'null') {
         $query =  $query->whereBetween('attdate', [$startDate, $endDate]);
      }
      if ($startDate != 'null' && $endDate == 'null') {
         $date = Carbon::createFromFormat('Y-m-d', $startDate);
         $month = $date->format('m');
         $year = $date->format('Y');
         $query =  $query->whereMonth('attdate', $month)->whereYear('attdate', $year);
      }

      $typecodes = [
         ['typecd' => 'attalpha', 'typedesc' => 'A']
      ];
      foreach ($query->get() as $attendaces_) {
         $typecode = $attendaces_['atttypes']['typecd'] ?? "attpresent";
         $typedesc = $attendaces_['atttypes']['typedesc'] ?? "Present";
         $typeExists = false;
         foreach ($typecodes as $type) {
            if ($type['typecd'] === $typecode) {
               $typeExists = true;
               break;
            }
         }

         if (!$typeExists) {
            $typecodes[] = [
               "typecd" => $typecode,
               "typedesc" => $typedesc
            ];
         }
      }

      $groupedData = $query->get()->groupBy(['attuserid', 'attdate']);

      $finalData = $groupedData->map(function ($group) use ($typecodes) {
         $attuser = $group->first()->first()->attuser;
         $attendance = [];
         $attendanceSummary = ['attalpha' => 0];
         foreach ($typecodes as $typecode) {
            $attendanceSummary[$typecode['typecd']] = 0;
         }

         foreach ($group as $item) {
            $attdate = $item->first()->attdate;
            $atttypecd = $item->first()->atttypes ? $item->first()->atttypes->typecd : "attpresent";
            $atttypedesc = $item->first()->atttypes ? $item->first()->atttypes->typedesc : null;
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
      $dataPerPage = $groupedData->count() > 15 ? 10 : 15;
      $totalPage = ceil(($groupedData->count()) / $dataPerPage);

      $response = [
         'data' => $finalData,
         'isLastPage' => $isLastPage,
         'typecodes' => $typecodes,
         'totalPages' => $totalPage,
         'dataPerPage' => $dataPerPage,
      ];

      return $response;
   }

   public function datatables($id, $startDate, $endDate, $userid)
   {
      $query = $this->getQuery()->select('*')
         ->where('attbpid', $id);
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
      ]);
   }
}
