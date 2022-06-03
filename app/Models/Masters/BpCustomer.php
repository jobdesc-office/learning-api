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

    public function sbcbp()
    {
        return $this->belongsTo(BusinessPartner::class, 'sbcbpid', 'bpid');
    }

    public function sbccstm()
    {
        return $this->belongsTo(Customer::class, 'sbccstmid', 'cstmid');
    }
}
