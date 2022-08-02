<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class DailyActivity extends DefaultModel
{
    protected $table = "vtdailyactivity";
    protected $primaryKey = "dailyactivityid";

    protected $fillable = [
        "dailyactivitycatid",
        "dailyactivitytypeid",
        "dailyactivityvalue",
        "dailyactivitydate",
        "dailyactivitydesc",
        "dailyactivityloc",
        "dailyactivitylatitude",
        "dailyactivitylongitude",
        "createdby",
        "updatedby",
        'isactive',
    ];

    public function dailyactivitycat()
    {
        return $this->belongsTo(Types::class, "dailyactivitycatid", "typeid");
    }

    public function dailyactivitytype()
    {
        return $this->belongsTo(Types::class, "dailyactivitytypeid", "typeid");
    }

    public function dailyactivitycreatedby()
    {
        return $this->hasOne(User::class, "userid", "createdby");
    }

    public function dailyactivitypics()
    {
        return $this->hasOne(Files::class, "refid", "dailyactivityid");
    }

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";
}
