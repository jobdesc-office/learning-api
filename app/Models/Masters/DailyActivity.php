<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class DailyActivity extends DefaultModel
{
    protected $table = "vtdailyactivity";
    protected $primaryKey = "dayactid";

    protected $fillable = [
        "dayactcatid",
        "dayacttypeid",
        "dayactvalue",
        "dayacttypevalue",
        "dayactdate",
        "dayactdesc",
        "dayactloc",
        "dayactlatitude",
        "dayactlongitude",
        "createdby",
        "updatedby",
        'isactive',
    ];

    public function dayactcat()
    {
        return $this->belongsTo(Types::class, "dayactcatid", "typeid");
    }

    public function dayacttype()
    {
        return $this->belongsTo(Types::class, "dayacttypeid", "typeid");
    }

    public function dayactpics()
    {
        return $this->hasOne(Files::class, "refid", "dayactid");
    }

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";
}
