<?php

namespace App\Services\Masters;

use App\Models\Masters\DspByStage;
use App\Services\Masters\InsightService;

class DspByStageService extends InsightService
{
   function getQuery()
   {
      return (new DspByStage)->newQuery()->with(['prospectbp']);
   }
}
