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
