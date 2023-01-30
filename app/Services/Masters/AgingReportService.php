<?php

namespace App\Services\Masters;

use App\Models\Masters\AgingReport;
use App\Models\Masters\UserDetail;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class AgingReportService extends AgingReport
{
   public function getAll(Collection $request)
   {
      $bpid = request()->header('bpid');

      $query = $this->getQuery();
      $query = $query->where('bpid', $bpid);

      if ($request->has('search')) {
         $query = $query->where(DB::raw('TRIM(LOWER(cstmname))'), 'like', "%" . Str::lower($request->get('search')) . "%");
      }

      if ($request->has('user')) {
         $user = UserDetail::find($request->get('user'));
         $users = kacungs($user->userdtsgid);
         $userids = $users->map(function ($item) {
            return $item->userdtid;
         })->toArray();
         $query = $query->whereIn('userid', $userids);
      }

      if ($request->has('filterduedate')) {
         $query = $query->where('duedate', Carbon::now()->format("Y-m-d"));
      }

      return $query->get();
   }

   public function getQuery()
   {
      return $this->newQuery()->with([
         'businesspartner',
         'user',
      ]);
   }
}
