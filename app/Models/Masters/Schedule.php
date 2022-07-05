<?php

namespace App\Models\Masters;

use Database\Factories\ScheduleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DefaultModel;

class Schedule extends DefaultModel
{
    use HasFactory;
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

    protected static function newFactory()
    {
        return new ScheduleFactory;
    }

    public function scheguest()
    {
        // return $this->hasOne(ScheduleGuest::class, 'scheid', 'scheid');
        return $this->hasMany(ScheduleGuest::class, 'scheid', 'scheid');
    }

    public function schetype()
    {
        return $this->belongsTo(Types::class, 'schetypeid', 'typeid');
    }

    public function schebp()
    {
        return $this->belongsTo(BusinessPartner::class, 'schebpid', 'bpid');
    }

    public function schetoward()
    {
        return $this->belongsTo(User::class, 'schetowardid', 'userid');
    }

    public function schereftype()
    {
        return $this->belongsTo(Types::class, 'schereftypeid', 'typeid');
    }
}
