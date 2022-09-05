<?php

namespace App\Services\Masters;

use App\Models\Masters\TrHistory;

class TrHistoryServices extends TrHistory
{
   public function findHistories($id, $tbname, $bpid)
   {
      return $this->getQuery()->where(['historyrefid' => $id, 'historybpid' => $bpid])->whereHas('historytbhistory', function ($query) use ($tbname) {
         $query->where('tbhistorytbname', $tbname);
      })->get();
   }

   public function getQuery()
   {
      return $this->newQuery()->with([
         'historytbhistory',
         'historyuser',
      ]);
   }
}
