<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class Province extends DefaultModel
{
    protected $table = "msprovince";
    protected $primaryKey = "provid";

    protected $fillable = [
        "provcountryid",
        "provname",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $alias = [
        "provcountryid" => "Country Id",
        "provname" => "Name",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function provcountry()
    {
        return $this->belongsTo(Country::class, 'provcountryid', 'countryid');
    }
}
