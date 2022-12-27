<?php

namespace App\Models\Masters;

use Database\Factories\CustomerFactory;
use Database\Factories\ScheduleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DefaultModel;

class Customer extends DefaultModel
{
    use HasFactory;
    protected $table = "mscustomer";
    protected $primaryKey = "cstmid";

    protected $fillable = [
        'cstmprefix',
        'cstmname',
        'cstmcode',
        'cstmphone',
        'cstmaddress',
        'cstmtypeid',
        'cstmprovinceid',
        'cstmcityid',
        'cstmsubdistrictid',
        'cstmuvid',
        'cstmpostalcode',
        'cstmlatitude',
        'cstmlongitude',
        'referalcode',
        'createdby',
        'updatedby',
        'isactive',
    ];

    protected $alias = [
        'cstmprefix' => "Prefix",
        'cstmname' => "Name",
        'cstmcode' => "Code",
        'cstmphone' => "Phone",
        'cstmaddress' => "Address",
        'cstmtypeid' => "Type Id",
        'cstmprovinceid' => "Province Id",
        'cstmcityid' => "City Id",
        'cstmsubdistrictid' => "Subdistrict Id",
        'cstmuvid' => "Urban Village Id",
        'cstmpostalcode' => "Postal Code",
        'cstmlatitude' => "Latitude",
        'cstmlongitude' => "Longitude",
        'referalcode' => "Referal Code",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    protected static function newFactory()
    {
        return new CustomerFactory;
    }

    public function cstmtype()
    {
        return $this->belongsTo(Types::class, 'cstmtypeid', 'typeid');
    }

    public function cstmprovince()
    {
        return $this->belongsTo(Province::class, 'cstmprovinceid', 'provid');
    }

    public function cstmcity()
    {
        return $this->belongsTo(City::class, 'cstmcityid', 'cityid');
    }

    public function cstmsubdistrict()
    {
        return $this->belongsTo(Subdistrict::class, 'cstmsubdistrictid', 'subdistrictid');
    }

    public function cstmvillage()
    {
        return $this->belongsTo(Village::class, 'cstmuvid', 'villageid');
    }

    public function custcreatedby()
    {
        return $this->belongsTo(User::class, "createdby", "userid");
    }

    public function custupdatedby()
    {
        return $this->belongsTo(User::class, "updatedby", "userid");
    }
}
