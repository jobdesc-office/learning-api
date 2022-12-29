<?php

namespace App\Services\Masters;

use App\Models\Masters\AgingReport;
use App\Models\Masters\Fcvsactual;
use App\Models\Masters\UserDetail;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FcvsactualService extends Fcvsactual
{
   public function getAll(Collection $request)
   {
      $bpid = request()->header('bpid');

      $query = $this->getQuery();
      $query = $query->where('bpid', $bpid);

      if ($request->has('search')) {
         $query = $query->where(DB::raw('TRIM(LOWER(username))'), 'like', "%" . Str::lower($request->get('search')) . "%");
      }

      if ($request->has('user')) {
         $user = UserDetail::find($request->get('user'));
         $users = kacungs($user->userdtsgid);
         $userids = $users->map(function ($item) {
            return $item->userdtid;
         })->toArray();
         $query = $query->whereIn('userid', $userids);
      }

      if ($request->has('year')) {
         $query = $query->where('yy', $request->get('year'));
      }

      if ($request->has('month')) {
         $query = $query->where('mm', $request->get('month'));
      }

      return $query->get();
   }

   public function getReportYearByBp($order = 'asc')
   {
      $bpid = request()->header('bpid');
      $query = $this->getQuery()->where('bpid', $bpid);
      return $query->select('yy')->groupBy('yy')->get()->map(function ($data) {
         return $data->yy;
      });
   }

   public function getQuery()
   {
      return $this->newQuery()->with([
         'businesspartner',
         'user',
      ]);
   }
}
