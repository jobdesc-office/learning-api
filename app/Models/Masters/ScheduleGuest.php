<?php

namespace App\Models\Masters;

use DBTypes;
use App\Models\DefaultModel;

class ScheduleGuest extends DefaultModel
{
    protected $table = "vtscheduleguest";
    protected $primaryKey = "scheguestid";

    protected $fillable = [
        "scheid",
        "scheuserid",
        "schebpid",
        "schepermisid"
    ];

    public function scheuser()
    {
        return $this->belongsTo(User::class, 'scheuserid', 'userid');
    }

    public function scheguestbp()
    {
        return $this->belongsTo(BusinessPartner::class, 'schebpid', 'bpid');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'scheid', 'scheid');
    }

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";
}
