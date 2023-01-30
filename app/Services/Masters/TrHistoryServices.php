<?php

namespace App\Services\Masters;

use App\Models\Masters\TrHistory;

class TrHistoryServices extends TrHistory
{
   public function findHistories($id, $tbname, $bpid)
   {
      return $this->getQuery()->where(['historyrefid' => $id, 'historybpid' => $bpid])->whereHas('historytbhistory', function ($query) use ($tbname) {
         $query->where('tbhistorytbname', $tbname);
      })->orderBy('createddate', 'desc')->get();
   }

   public function findProspectFileHistories($id, $tbname, $bpid)
   {
      return $this->getQuery()->where('historybpid', $bpid)
         ->whereHas('historyrefprospectfile', function ($query) use ($id) {
            $query->whereHas('transtype', function ($query) {
               $query->where('typecd', \DBTypes::prospectfile);
            })->where('refid', $id);
         })
         ->whereHas('historytbhistory', function ($query) use ($tbname) {
            $query->where('tbhistorytbname', $tbname);
         })
         ->orderBy('createddate', 'desc')
         ->get();
   }

   public function findProspectCustomfieldHistories($id, $tbname, $bpid)
   {
      return $this->getQuery()->where('historybpid', $bpid)
         ->whereHas('historyrefprospectcustomfield', function ($query) use ($id) {
            $query->where('prospectid', $id);
         })
         ->whereHas('historytbhistory', function ($query) use ($tbname) {
            $query->where('tbhistorytbname', $tbname);
         })
         ->orderBy('createddate', 'desc')
         ->get();
   }

   public function findProspectActivityHistories($id, $tbname, $bpid)
   {
      return $this->getQuery()->where('historybpid', $bpid)
         ->whereHas('historyrefprospectactivity', function ($query) use ($id) {
            $query->where('dayactreftypeid', find_type()->in([\DBTypes::dayactreftypeprospect])->get(\DBTypes::dayactreftypeprospect)->getId())
               ->where('dayactrefid', $id);
         })
         ->whereHas('historytbhistory', function ($query) use ($tbname) {
            $query->where('tbhistorytbname', $tbname);
         })
         ->orderBy('createddate', 'desc')
         ->get();
   }

   public function findProspectAssignHistories($id, $tbname, $bpid)
   {
      return $this->getQuery()->where('historybpid', $bpid)
         ->whereHas('historyrefprospectassign', function ($query) use ($id) {
            $query->where('prospectid', $id);
         })
         ->whereHas('historytbhistory', function ($query) use ($tbname) {
            $query->where('tbhistorytbname', $tbname);
         })
         ->orderBy('createddate', 'desc')
         ->get();
   }

   public function findProspectProductHistories($id, $tbname, $bpid)
   {
      return $this->getQuery()->where('historybpid', $bpid)
         ->whereHas('historyrefprospectproduct', function ($query) use ($id) {
            $query->where('prosproductprospectid', $id);
         })
         ->whereHas('historytbhistory', function ($query) use ($tbname) {
            $query->where('tbhistorytbname', $tbname);
         })
         ->orderBy('createddate', 'desc')
         ->get();
   }

   public function prospectQuery()
   {
      return $this->getQuery()->with([
         'historyrefprospectproduct',
         'historyrefprospectassign',
         'historyrefprospectactivity',
         'historyrefprospectcustomfield',
      ]);
   }

   public function getQuery()
   {
      return $this->newQuery()->with([
         'historytbhistory',
         'historyuser',
      ]);
   }
}
