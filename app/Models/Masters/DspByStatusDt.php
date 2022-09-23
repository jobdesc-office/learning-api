<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class DspByStatusDt extends DefaultModel
{
   protected $table = "dspbystatusdt";

   protected $connection = 'pgsql2';

   protected $fillable = [
      "prospectbpid",
      "prospectbpname",
      "prospectstatus",
      "prospectcustid",
      "prospectcustname",
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
      "prospectcustid" => "",
      "prospectcustname" => "",
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

   public function prospectcust()
   {
      return $this->belongsTo(BpCustomer::class, 'prospectcustid', 'sbcid');
   }
}
