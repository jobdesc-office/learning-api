<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class Attendance extends DefaultModel
{
   protected $table = "vtattendance";
   protected $primaryKey = "attid";

   protected $casts = [
      'attlatin' => 'double',
      'attlongin' => 'double',
      'attlatout' => 'double',
      'attlongout' => 'double',
   ];

   protected $fillable = [
      "attbpid",
      "attuserid",
      "attdate",
      "attclockin",
      "attclockout",
      "attlatin",
      "attlongin",
      "attaddressin",
      "attlatout",
      "attlongout",
      "attaddressout",
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
      "attlatin" => "Clock In Latitude",
      "attlongin" => "Clock In Longitude",
      "attaddressin" => "Clock In Address",
      "attlatin" => "Clock Out Latitude",
      "attlongin" => "Clock Out Longitude",
      "attaddressin" => "Clock Out Address",
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
