<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class Files extends DefaultModel
{
   protected $table = "msfiles";
   protected $primaryKey = "fileid";

   protected $fillable = [
      "transtypeid",
      "refid",
      "directories",
      "filename",
      'mimetype',
      "filesize",
      "createdby",
      "updatedby",
      "isactive",
   ];

   const CREATED_AT = "createddate";
   const UPDATED_AT = "updateddate";

   public function transtype()
   {
      return $this->belongsTo(Types::class, 'transtypeid', 'typeid');
   }
}
