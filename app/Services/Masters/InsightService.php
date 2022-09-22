<?php

namespace App\Services\Masters;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

abstract class InsightService
{
   public function getReportByBp($bpid, Collection $collection, $order = 'asc')
   {
      $query = $this->getQuery()->where('prospectbpid', $bpid)->orderBy('prospectvalue', $order);
      $query = $query->where($collection->filter()->all());
      return $query->get();
   }

   public function getReportYearByBp($bpid, $order = 'asc')
   {
      $query = $this->getQuery()->where('prospectbpid', $bpid)->orderBy('prospectvalue', 'desc');
      return $query->select('prospectyy')->groupBy('prospectyy')->get()->map(function ($data) {
         return $data->prospectyy;
      });
   }

   /**
    * @return Builder
    */
   abstract function getQuery();
}
