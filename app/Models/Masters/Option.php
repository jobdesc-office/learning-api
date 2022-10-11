<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class Option extends DefaultModel
{
    protected $table = "vtoption";
    protected $primaryKey = "optid";

    protected $fillable = [
        "custfid",
        "optvalue",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $alias = [
        "custfid" => "CustomField ID",
        "optvalue" => "Value",
        "createdby" => "Craeted By",
        "updatedby" => "Updated By",
        'isactive' => "Is Active",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function customizefield()
    {
        return $this->belongsTo(CustomField::class, 'custfid', 'custfid');
    }

    public function optioncreatedby()
    {
        return $this->belongsTo(User::class, "createdby", "userid");
    }

    public function optionupdatedby()
    {
        return $this->belongsTo(User::class, "updatedby", "userid");
    }
}
