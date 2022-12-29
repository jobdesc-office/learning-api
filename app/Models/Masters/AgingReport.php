<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class AgingReport extends DefaultModel
{
   protected $table = "agingreport";

   protected $connection = 'pgsql2';
   public $timestamps = false;

   protected $fillable = [
      "bpid",
      "userid",
      "usercode",
      "userfullname",
      "cstmcode",
      "cstmname",
      "invno",
      "invdate",
      "duedate",
      'outstandinginv',
   ];

   protected $alias = [
      "bpid" => "bpid",
      "userid" => "userid",
      "usercode" => "usercode",
      "userfullname" => "userfullname",
      "cstmcode" => "cstmcode",
      "cstmname" => "cstmname",
      "invno" => "invno",
      "invdate" => "invdate",
      "duedate" => "duedate",
      'outstandinginv' => "outstandinginv",
   ];

   protected $casts = [
      "outstandinginv" => "float",
      "bpid" => "integer",
      "userid" => "integer",
   ];

   public function businesspartner()
   {
      return $this->belongsTo(BusinessPartner::class, 'bpid', 'bpid');
   }

   public function user()
   {
      return $this->belongsTo(User::class, 'userid', 'userid');
   }
}
