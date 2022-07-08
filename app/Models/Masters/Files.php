<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;
use Illuminate\Support\Facades\Storage;
use Log;

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

   public static function boot()
   {
      parent::boot();

      static::deleted(function ($item) {
         Log::info($item);
         Storage::disk('public')->delete("$item->directories$item->filename");
      });

      static::deleting(function ($item) {
         Log::info($item);
         Storage::disk('public')->delete("$item->directories$item->filename");
      });
   }

   public function transtype()
   {
      return $this->belongsTo(Types::class, 'transtypeid', 'typeid');
   }
}
