<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = "vtschedule";
    protected $primaryKey = "scheid";

    protected $fillable = [
        "schenm",
        "schestartdate",
        "scheenddate",
        "schestarttime",
        "scheendtime",
        "schetypeid",
        "scheactdate",
        "schetowardid",
        "schebpid",
        "schereftypeid",
        "scherefid",
        "scheallday",
        "scheloc",
        "scheprivate",
        "scheonline",
        "schetz",
        "scheremind",
        "schedesc",
        "scheonlink",
        "createdby",
        "updatedby",
        'isactive'
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function scheguest()
    {
        return $this->hasMany(ScheduleGuest::class, 'scheid', 'scheid');
    }

    public function schetype()
    {
        return $this->hasOne(Types::class, 'typeid', 'schetypeid');
    }

    public function schebp()
    {
        return $this->hasOne(BusinessPartner::class, 'bpid', 'schebpid');
    }

    public function schetoward()
    {
        return $this->hasOne(User::class, 'userid', 'schetowardid');
    }

    public function schereftype()
    {
        return $this->hasOne(Types::class, 'typeid', 'schereftypeid');
    }
}
