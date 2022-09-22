<?php

namespace App\Services\Masters;

use App\Models\Masters\DspByCustLabelDt;
use App\Services\Masters\InsightService;

class DspByCustLabelDtService extends InsightService
{
   function getQuery()
   {
      return (new DspByCustLabelDt)->newQuery()->with(['prospectbp']);
   }
}
