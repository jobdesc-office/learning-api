<?php

namespace App\Models\Masters;

use DBTypes;
use Illuminate\Database\Eloquent\Model;

class ScheduleGuest extends Model
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

    public function schebp()
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
