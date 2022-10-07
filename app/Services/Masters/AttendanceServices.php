<?php

namespace App\Services\Masters;

use App\Models\Masters\Attendance;
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

      return $query->get();
   }

   public function datatables($id, $startDate, $endDate, $userid)
   {
      $query = $this->getQuery()->select('*')
         ->whereBetween('attdate', [$startDate, $endDate])
         ->where('attbpid', $id);
      if ($userid != null) {
         $query =  $query->where('attuserid', $userid);
      }
      return $query;
   }

   public function getQuery()
   {
      return $this->newQuery()->with([
         'attuser',
         'attbp',
      ]);
   }
}
