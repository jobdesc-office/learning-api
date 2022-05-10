<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = "mscountry";
    protected $primaryKey = "typeid";

    protected $fillable = [
        "typecd",
        "typename",
        "typeseq",
        "typemasterid",
        "typedesc",
        "createdby",
        "updatedby",
        'isactive',
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function parent()
    {
        return $this->hasOne(Types::class, 'typeid', 'typemasterid');
    }
}
