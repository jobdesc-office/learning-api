<?php

namespace App\Models\Masters;

use Database\Factories\CustomerFactory;
use Database\Factories\ScheduleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = "mscustomer";
    protected $primaryKey = "cstmid";

    protected $fillable = [
        'cstmprefix',
        'cstmname',
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

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    protected static function newFactory()
    {
        return new CustomerFactory;
    }

    public function cstmtype()
    {
        return $this->hasOne(Types::class, 'typeid', 'cstmtypeid');
    }

    public function cstmprovince()
    {
        return $this->hasOne(Province::class, 'provid', 'cstmprovinceid');
    }

    public function cstmcity()
    {
        return $this->hasOne(City::class, 'cityid', 'cstmcityid');
    }

    public function cstmsubdistrict()
    {
        return $this->hasOne(Subdistrict::class, 'subdistrictid', 'cstmsubdistrictid');
    }
}
