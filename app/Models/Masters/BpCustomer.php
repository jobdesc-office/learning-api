<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DefaultModel;

class BpCustomer extends DefaultModel
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
        'createdby',
        'updatedby',
        'isactive'
    ];

    protected $alias = [
        'sbcbpid' => "Business Partner Id",
        'sbccstmid' => "Id",
        'sbccstmstatusid' => "Status Id",
        'sbccstmname' => "Name",
        'sbccstmphone' => "Phone",
        'sbccstmaddress' => "Address",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function sbccstmstatus()
    {
        return $this->hasOne(Types::class, 'typeid', 'sbccstmstatusid');
    }

    public function sbcbp()
    {
        return $this->belongsTo(BusinessPartner::class, 'sbcbpid', 'bpid');
    }

    public function sbccstm()
    {
        return $this->belongsTo(Customer::class, 'sbccstmid', 'cstmid');
    }

    public function sbccstmpics()
    {
        return $this->hasMany(Files::class, 'refid', 'sbcid');
    }
}
