<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class Fcvsactual extends DefaultModel
{
   protected $table = "fcvsactual";

   protected $connection = 'pgsql2';
   public $timestamps = false;

   protected $fillable = [
      "bpid",
      "yy",
      "mm",
      "branchnm",
      "group4",
      "userid",
      "usercode",
      "username",
      "actamount",
      "fcamount",
      "actqty",
      'fcqty',
      'seq'
   ];

   protected $alias = [];

   protected $casts = [
      "actamount" => "float",
      "fcamount" => "float",
      "actqty" => "float",
      "fcqty" => "float",
      "seq" => "integer",
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
