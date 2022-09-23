<?php

namespace App\Services\Masters;

use App\Models\Masters\DspByStatusDt;
use App\Services\Masters\InsightService;

class DspByStatusDtService extends InsightService
{
   function getQuery()
   {
      return (new DspByStatusDt)->newQuery()->with(['prospectbp', 'prospectcust']);
   }
}
