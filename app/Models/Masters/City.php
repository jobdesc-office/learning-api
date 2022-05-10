<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = "mscity";
    protected $primaryKey = "cityid";

    protected $fillable = [
        "cityname",
        "cityprovid",
        "createdby",
        "updatedby",
        'isactive',
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function cityprov()
    {
        $this->belongsTo(Province::class, 'cityprovid', 'provid');
    }
}
