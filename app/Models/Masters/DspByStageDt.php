<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class DspByStageDt extends DefaultModel
{
   protected $table = "dspbystagedt";

   protected $connection = 'pgsql2';

   protected $fillable = [
      "prospectbpid",
      "prospectbpname",
      "prospectstage",
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
      "prospectstage" => "",
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

   public function prospectstagetype()
   {
      return $this->belongsTo(Stbptype::class, 'prospectstage', 'sbtid');
   }

   public function prospectcust()
   {
      return $this->belongsTo(BpCustomer::class, 'prospectcustid', 'sbcid');
   }
}
