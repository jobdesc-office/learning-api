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
        "dayactloclabel",
        "dayactloc",
        "dayactlatitude",
        "dayactlongitude",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $alias = [
        "dayactcatid" => "Category Id",
        "dayacttypeid" => "Type Id",
        "dayactcustid" => "BpCustomer Id",
        "dayacttypevalue" => "Subject",
        "dayactdate" => "Date",
        "dayactdesc" => "Description",
        "dayactloclabel" => "Location Label",
        "dayactloc" => "Location",
        "dayactlatitude" => "Latitude",
        "dayactlongitude" => "Longitude",
    ];

    protected $casts = [
        'dayactlatitude' => 'double',
        'dayactlongitude' => 'double',
    ];

    protected static function newFactory()
    {
        return new DailyActivityFactory;
    }

    public function dayactuser()
    {
        return $this->belongsTo(User::class, "createdby", "userid");
    }

    public function dayactcat()
    {
        return $this->belongsTo(Types::class, "dayactcatid", "typeid");
    }

    public function dayactcust()
    {
        return $this->belongsTo(BpCustomer::class, "dayactcustid", "cstmid");
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
