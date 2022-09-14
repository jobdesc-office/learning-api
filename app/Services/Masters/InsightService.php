<?php

namespace App\Services\Masters;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

abstract class InsightService
{
   public function getReportByBp($bpid, Collection $collection)
   {
      $query = $this->getQuery()->where('prospectbpid', $bpid);
      if ($collection->has('prospectyy')) $query = $query->where('prospectyy', $collection->get('prospectyy'));
      if ($collection->has('prospectmm')) $query = $query->where('prospectmm', $collection->get('prospectmm'));
      return $query->get();
   }

   public function getReportYearByBp($bpid)
   {
      $query = $this->getQuery()->where('prospectbpid', $bpid);
      return $query->select('prospectyy')->groupBy('prospectyy')->get()->map(function ($data) {
         return $data->prospectyy;
      });
   }

   /**
    * @return Builder
    */
   abstract function getQuery();
}
