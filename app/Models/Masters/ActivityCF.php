<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class ActivityCF extends DefaultModel
{
    protected $table = "activitycf";
    protected $primaryKey = "activitycfid";

    protected $fillable = [
        "activityid",
        "activitycustfid",
        "activitycfvalue",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $alias = [
        "activityid" => "Prospect Id",
        "activitycustfid" => "Custom Field Id",
        "activitycfvalue" => "Custom Field Value",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function activity()
    {
        return $this->belongsTo(DailyActivity::class, "activityid", "activityid");
    }

    public function customfield()
    {
        return $this->belongsTo(ActivityCustomField::class, 'activitycustfid', 'custfid');
    }
}
