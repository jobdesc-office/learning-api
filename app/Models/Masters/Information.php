<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class Information extends DefaultModel
{

    protected $table = "msinformation";
    protected $primaryKey = "infoid";

    protected $fillable = [
        "infoname",
        "infodesc",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $alias = [
        'infoname' => "Name",
        'infodesc' => "Description",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";
}
