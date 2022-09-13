<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;
use Database\Factories\ContactFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactPerson extends DefaultModel
{
    use HasFactory;

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

    protected static function newFactory()
    {
        return new ContactFactory();
    }

    public function contacttype()
    {
        return $this->belongsTo(Types::class, "contacttypeid", "typeid");
    }

    public function contactcustomer()
    {
        return $this->belongsTo(BpCustomer::class, "contactcustomerid", "cstmid");
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
