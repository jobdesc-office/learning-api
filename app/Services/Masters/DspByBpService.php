<?php

namespace App\Services\Masters;

use App\Services\Masters\InsightService;
use DB;

class DspByBpService extends InsightService
{
   function getQuery()
   {
      return DB::connection('pgsql2')->table("dspbybp");
   }
}
