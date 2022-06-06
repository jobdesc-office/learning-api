<?php

namespace App\Models\Masters;

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

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";
}
