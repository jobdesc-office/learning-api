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

    protected $alias = [
        "contactcustomerid" => "Customer Id",
        "contacttypeid" => "Type Id",
        "contactvalueid" => "Value",
        "contactname" => "Name",
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
}
