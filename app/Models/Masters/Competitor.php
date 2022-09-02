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

   public function comptpics()
   {
      return $this->hasMany(Files::class, 'refid', 'comptid');
   }

   public function comptcreatedby()
   {
      return $this->belongsTo(User::class, "createdby", "userid");
   }

   public function comptupdatedby()
   {
      return $this->belongsTo(User::class, "updatedby", "userid");
   }
}
