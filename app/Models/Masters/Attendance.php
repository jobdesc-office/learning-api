<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class Attendance extends DefaultModel
{
   protected $table = "vtattendance";
   protected $primaryKey = "attid";

   protected $casts = [
      'attlat' => 'double',
      'attlong' => 'double',
   ];

   protected $fillable = [
      "attbpid",
      "attuserid",
      "attdate",
      "attclockin",
      "attclockout",
      "attlat",
      "attlong",
      "attaddress",
      "createdby",
      "updatedby",
      'isactive',
   ];

   protected $alias = [
      "attbpid" => "Business Partner",
      "attuserid" => "User Id",
      "attdate" => "Date",
      "attclockin" => "Clock In",
      "attclockout" => "Clock Out",
      "attlat" => "Latitude",
      "attlong" => "Longitude",
      "attaddress" => "Address",
   ];

   const CREATED_AT = "createddate";
   const UPDATED_AT = "updateddate";

   public function attuser()
   {
      return $this->belongsTo(User::class, "attuserid", "userid");
   }

   public function attbp()
   {
      return $this->belongsTo(BusinessPartner::class, "attbpid", "bpid");
   }
}
