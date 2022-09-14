<?php

namespace App\Services\Masters;

use App\Models\Masters\DspByCustLabel;
use App\Services\Masters\InsightService;

class DspByCustLabelService extends InsightService
{
   function getQuery()
   {
      return (new DspByCustLabel)->newQuery()->with(['prospectbp']);
   }
}
