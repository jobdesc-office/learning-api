<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class ContactPerson extends DefaultModel
{
    protected $table = "mscontactperson";
    protected $primaryKey = "contactpersonid";

    protected $fillable = [
        "contactcustomerid",
        "contacttypeid",
        "contactvalueid",
        "contactname",
        "createdby",
        "updatedby",
        'isactive',
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function contacttype()
    {
        return $this->belongsTo(Types::class, "contacttypeid", "typeid");
    }

    public function contactcustomer()
    {
        return $this->belongsTo(Customer::class, "contactcustomerid", "cstmid");
    }

    public function contactcreatedby()
    {
        return $this->belongsTo(User::class, "createdby", "userid");
    }

    public function contactupdatedby()
    {
        return $this->belongsTo(User::class, "updatedby", "userid");
    }
}
