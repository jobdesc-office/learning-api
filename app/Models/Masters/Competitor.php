<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class Competitor extends DefaultModel
{
   protected $table = "vtcompetitor";
   protected $primaryKey = "comptid";

   protected $fillable = [
      "comptbpid",
      "comptreftypeid",
      "comptrefid",
      "comptname",
      'comptproductname',
      "description",
      "createdby",
      "updatedby",
      "isactive",
   ];

   const CREATED_AT = "createddate";
   const UPDATED_AT = "updateddate";

   public function comptbp()
   {
      return $this->belongsTo(BusinessPartner::class, 'comptbpid', 'bpid');
   }

   public function comptreftype()
   {
      return $this->belongsTo(Types::class, 'comptreftypeid', 'typeid');
   }
}
