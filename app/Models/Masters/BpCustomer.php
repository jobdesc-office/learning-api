<?php

namespace App\Models\Masters;

use Database\Factories\BpCustomerFactory;
use Database\Factories\ScheduleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BpCustomer extends Model
{
    use HasFactory;
    protected $table = "stbpcustomer";
    protected $primaryKey = "sbcid";

    protected $fillable = [
        'sbcbpid',
        'sbccstmid',
        'sbccstmstatusid',
        'sbccstmname',
        'sbccstmphone',
        'sbccstmaddress',
        'sbccstmpic',
        'createdby',
        'updatedby',
        'isactive'
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    protected static function newFactory()
    {
        return new BpCustomerFactory;
    }

    public function sbcbp()
    {
        return $this->hasOne(BusinessPartner::class, 'bpid', 'sbcbpid');
    }

    public function sbccstm()
    {
        return $this->hasOne(Customer::class, 'cstmid', 'sbccstmid');
    }
}
