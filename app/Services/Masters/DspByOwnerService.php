<?php

namespace App\Services\Masters;

use App\Models\Masters\DspByOwner;
use App\Services\Masters\InsightService;
use DB;

class DspByOwnerService extends InsightService
{
   function getQuery()
   {
      return (new DspByOwner)->newQuery()->with(['prospectbp', 'prospectowneruser']);
   }
}
