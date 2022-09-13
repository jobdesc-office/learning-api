<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class DspByBp extends DefaultModel
{
   protected $table = "dspbybp";

   protected $connection = 'pgsql2';

   protected $fillable = [
      "prospectbpid",
      "prospectbpname",
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

   public function prospectcust()
   {
      return $this->belongsTo(BpCustomer::class, 'prospectcustid', 'sbcid');
   }
}
