<?php

namespace App\Services\Masters;

use App\Models\Masters\DspByCust;
use Illuminate\Support\Collection;

class DspByCustServices extends DspByCust
{

   function reportByBp(Collection $collection)
   {
      $query = $this->getQuery()->where('prospectbpid', $collection->get('bpid'));
      if ($collection->has('prospectyy')) $query = $query->where('prospectyy', $collection->get('prospectyy'));
      if ($collection->has('prospectmm')) $query = $query->where('prospectmm', $collection->get('prospectmm'));
      return $query->get();
   }

   function getReportYearsByBp($bpid)
   {
      $query = $this->newQuery()->where('prospectbpid', $bpid);
      return $query->select('prospectyy')->groupBy('prospectyy')->get()->map(function ($data) {
         return $data->prospectyy;
      });
   }

   function getQuery()
   {
      return $this->newQuery()->with(['prospectbp', "prospectcust"]);
   }
}
