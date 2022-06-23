<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = "mscountry";
    protected $primaryKey = "countryid";

    protected $fillable = [
        "countryname",
        "createdby",
        "updatedby",
        'isactive',
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function provinces()
    {
        return $this->hasMany(Province::class, 'provcountryid', 'countryid');
    }
}
