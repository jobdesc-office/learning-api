<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class BpQuota extends DefaultModel
{
   protected $table = "stbpquota";
   protected $primaryKey = "sbqid";

   protected $fillable = [
      "sbqbpid",
      "sbqwebuserquota",
      'sbqmobuserquota',
      "sbqcstmquota",
      "sbqcntcquota",
      "sbqprodquota",
      "sbqprosquota",
      "sbqdayactquota",
      "sbqprosactquota",
      "createdby",
      "updatedby",
      'isactive',
   ];

   protected $alias = [
      "sbqbpid" => "Business Partner Id",
      "sbqwebuserquota" => "Web User Quota",
      "sbqmobuserquota" => "Mobile User Quota",
      "sbqcstmquota" => "Customer Quota",
      "sbqcntcquota" => "Contact Quota",
      "sbqprodquota" => "Product Quota",
      "sbqprosquota" => "Prospect Quota",
      "sbqdayactquota" => "Daily Activity Quota",
      "sbqprosactquota" => "Prospect Activity Quota"
   ];

   const CREATED_AT = "createddate";
   const UPDATED_AT = "updateddate";

   public function businesspartner()
   {
      return $this->belongsTo(BusinessPartner::class, 'cityprovid', 'provid');
   }
}
