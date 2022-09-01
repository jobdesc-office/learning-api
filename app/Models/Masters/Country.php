<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class Country extends DefaultModel
{
    protected $table = "mscountry";
    protected $primaryKey = "countryid";

    protected $fillable = [
        "countryname",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $alias = [
        "countryname" => "Name",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function provinces()
    {
        return $this->hasMany(Province::class, 'provcountryid', 'countryid');
    }
}
