<?php

namespace App\Services\Masters;

use App\Models\Masters\DspByStageDt;
use App\Services\Masters\InsightService;

class DspByStageDtService extends InsightService
{
   function getQuery()
   {
      return (new DspByStageDt)->newQuery()->with(['prospectbp', 'prospectcust']);
   }
}
