<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;
use Database\Factories\DailyActivityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyActivity extends DefaultModel
{
    use HasFactory;
    protected $table = "vtdailyactivity";
    protected $primaryKey = "dayactid";

    protected $fillable = [
        "dayactcatid",
        "dayacttypeid",
        "dayactcustid",
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

    protected static function newFactory()
    {
        return new DailyActivityFactory;
    }
    public function dayactcat()
    {
        return $this->belongsTo(Types::class, "dayactcatid", "typeid");
    }

    public function dayactcust()
    {
        return $this->belongsTo(Customer::class, "dayactcustid", "cstmid");
    }

    public function dayacttype()
    {
        return $this->belongsTo(Types::class, "dayacttypeid", "typeid");
    }

    public function dayactpics()
    {
        return $this->hasOne(User::class, "userid", "createdby");
    }

    public function dailyactivitypics()
    {
        return $this->hasOne(Files::class, "refid", "dayactid");
    }

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";
}
