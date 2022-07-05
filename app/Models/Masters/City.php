<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class City extends DefaultModel
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
        return $this->belongsTo(Province::class, 'cityprovid', 'provid');
    }
}
