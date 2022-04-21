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
    protected $primaryKey = "bpcustomerid";

    protected $fillable = [
        'bpid',
        'customerid',
        'customername',
        'customerphone',
        'customeraddress',
        'customerpic',
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

    public function customerbp()
    {
        return $this->hasOne(Types::class, 'bpid', 'bpid');
    }

    public function customer()
    {
        return $this->hasOne(Types::class, 'customerid', 'customerid');
    }
}
