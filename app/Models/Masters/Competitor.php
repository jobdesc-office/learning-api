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

   protected $alias = [
      "comptbpid" => "Business Partner Id",
      "comptreftypeid" => "Reference Type Id",
      "comptrefid" => "Reference Id",
      "comptname" => "Name",
      'comptproductname' => "Product Name",
      "description" => "Description",
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

   public function comptpics()
   {
      return $this->hasMany(Files::class, 'refid', 'comptid');
   }
}
