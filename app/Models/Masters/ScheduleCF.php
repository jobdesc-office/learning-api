<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class ScheduleCF extends DefaultModel
{
    protected $table = "trschedulecf";
    protected $primaryKey = "schedulecfid";

    protected $fillable = [
        "scheduleid",
        "schedulecustfid",
        "schedulecfvalue",
        "optchoosed",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $alias = [
        "scheduleid" => "Schedule Id",
        "schedulecustfid" => "Custom Field Id",
        "schedulecfvalue" => "Custom Field Value",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function schedule()
    {
        return $this->belongsTo(DailyActivity::class, "scheduleid", "dayactid");
    }

    public function customfield()
    {
        return $this->belongsTo(CustomField::class, 'schedulecustfid', 'custfid');
    }

    public function selectedoption()
    {
        return $this->belongsTo(Option::class, 'optchoosed', 'optid');
    }
}
