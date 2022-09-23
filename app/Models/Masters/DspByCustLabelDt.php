<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class DspByCustLabelDt extends DefaultModel
{
   protected $table = "dspbycustlabeldt";

   protected $connection = 'pgsql2';

   protected $fillable = [
      "prospectbpid",
      "prospectbpname",
      "prospectcustlabel",
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
      "prospectcustlabel" => "",
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

   public function prospectcustlabeltype()
   {
      return $this->belongsTo(Stbptype::class, 'prospectcustlabel', 'sbtid');
   }

   public function prospectcust()
   {
      return $this->belongsTo(BpCustomer::class, 'prospectcustid', 'sbcid');
   }
}
