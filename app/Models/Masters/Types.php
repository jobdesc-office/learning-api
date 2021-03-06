<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class Types extends DefaultModel
{
    protected $table = "mstype";
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
        return $this->belongsTo(Types::class, 'typemasterid', 'typeid');
    }
}
