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
        "schecd",
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

    protected $alias = [
        "schenm" => "Name",
        "schecd" => "Code",
        "schestartdate" => "Start Date",
        "scheenddate" => "End Date",
        "schestarttime" => "Start Time",
        "scheendtime" => "End Time",
        "schetypeid" => "Type Id",
        "scheactdate" => "Actual Date",
        "schetowardid" => "Toward Id",
        "schebpid" => "Business Partner Id",
        "schereftypeid" => "Reference Type Id",
        "scherefid" => "Reference Id",
        "scheallday" => "All Day",
        "scheloc" => "Location",
        "scheprivate" => "Private",
        "scheonline" => "Online",
        "schetz" => "Timezone",
        "scheremind" => "Remind",
        "schedesc" => "Description",
        "scheonlink" => "Online Link",
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

    public function schecreatedby()
    {
        return $this->belongsTo(User::class, "createdby", "userid");
    }

    public function scheupdatedby()
    {
        return $this->belongsTo(User::class, "updatedby", "userid");
    }

    public function schedulecustomfield()
    {
        return $this->hasMany(ScheduleCF::class, "scheduleid", "scheid");
    }
}
