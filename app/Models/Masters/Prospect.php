<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
    protected $table = "trprospect";
    protected $primaryKey = "prospectid";

    protected $fillable = [
        "prospectname",
        "prospectstartdate",
        "prospectenddate",
        "prospectvalue",
        "prospectowner",
        "prospectstageid",
        "prospectstatusid",
        "prospectexpclosedate",
        "prospectbpid",
        "prospectdescription",
        "prospectcustid",
        "prospectrefid",
        "createdby",
        "updatedby",
        'isactive',
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function prospectowneruser()
    {
        return $this->belongsTo(UserDetail::class, "prospectowner", "userdtid");
    }

    public function prospectreference()
    {
        return $this->belongsTo(Prospect::class, "prospectrefid", "prospectid");
    }

    public function prospectstage()
    {
        return $this->belongsTo(Types::class, "prospectstageid", "typeid");
    }

    public function prospectstatus()
    {
        return $this->belongsTo(Types::class, "prospectstatusid", "typeid");
    }

    public function prospectbp()
    {
        return $this->belongsTo(BusinessPartner::class, "prospectbpid", "bpid");
    }

    public function prospectcust()
    {
        return $this->belongsTo(BpCustomer::class, "prospectcustid", "sbcid");
    }

    public function prospectassigns()
    {
        return $this->hasMany(ProspectAssign::class, "prospectid", "prospectid");
    }

    public function prospectproduct()
    {
        return $this->hasMany(ProspectProduct::class, "prosproductprospectid", "prospectid");
    }
}
