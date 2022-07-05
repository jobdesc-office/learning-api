<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class Subdistrict extends DefaultModel
{
    protected $table = "mssubdistrict";
    protected $primaryKey = "subdistrictid";

    protected $fillable = [
        "subdistrictcityid",
        "subdistrictname",
        "createdby",
        "updatedby",
        'isactive',
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function subdistrictcity()
    {
        return $this->belongsTo(City::class, 'subdistrictcityid', 'cityid');
    }
}
