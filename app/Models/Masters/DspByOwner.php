<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class DspByOwner extends DefaultModel
{
   protected $table = "dspbyowner";

   protected $connection = 'pgsql2';

   protected $fillable = [
      "prospectbpid",
      "prospectbpname",
      "prospectownerid",
      "prospectowner",
      "prospectstatus",
      "prospectstage",
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
      "prospectownerid" => "",
      "prospectowner" => "",
      "prospectstatus" => "",
      "prospectstage" => "",
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

   public function prospectowneruser()
   {
      return $this->belongsTo(UserDetail::class, 'prospectownerid', 'userdtid');
   }
}
