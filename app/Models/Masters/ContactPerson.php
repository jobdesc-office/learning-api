<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class ContactPerson extends Model
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
}
