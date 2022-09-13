<?php

namespace App\Services\Masters;

use App\Models\Masters\DspByStatus;
use App\Services\Masters\InsightService;

class DspByStatusService extends InsightService
{
   function getQuery()
   {
      return (new DspByStatus)->newQuery()->with(['prospectbp']);
   }
}
