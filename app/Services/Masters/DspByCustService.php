<?php

namespace App\Services\Masters;

use App\Models\Masters\DspByCust;
use App\Services\Masters\InsightService;

class DspByCustService extends InsightService
{
   function getQuery()
   {
      return (new DspByCust)->newQuery()->with(['prospectbp', 'prospectcust']);
   }
}
