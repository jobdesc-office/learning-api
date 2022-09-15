<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class DspByStatus extends DefaultModel
{
   protected $table = "dspbystatus";

   protected $connection = 'pgsql2';

   protected $fillable = [
      "prospectbpid",
      "prospectbpname",
      "prospectstatus",
      "prospectyy",
      "prospectmm",
      "prospectvalue",
      "createdby",
      "updatedby",
      'isactive',
   ];

   protected $alias = [
      "prospectbpid" => "",
      "prospectbpname" => "",
      "prospectstatus" => "",
      "prospectyy" => "",
      "prospectmm" => "",
      "prospectvalue" => "",
   ];

   protected $casts = [
      'prospectyy' => 'integer',
      'prospectmm' => 'integer',
      "prospectvalue" => "integer",
   ];

   const CREATED_AT = "createddate";
   const UPDATED_AT = "updateddate";

   public function prospectbp()
   {
      return $this->belongsTo(BusinessPartner::class, 'prospectbpid', 'bpid');
   }

   public function prospectstatustype()
   {
      return $this->belongsTo(Stbptype::class, 'prospectstatus', 'sbtid');
   }
}
