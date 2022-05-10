<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
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

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function provcountry()
    {
        return $this->belongsTo(Country::class, 'provcountryid', 'countryid');
    }
}
