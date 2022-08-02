<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class Prospect extends DefaultModel
{
    protected $table = "trprospect";
    protected $primaryKey = "prospectid";

    protected $fillable = [
        "prospectname",
        "prospectcode", // Kode + tahun + bulan + 00001
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
        "prospectlostreasonid",
        "prospectlostdesc",
        "createdby",
        "updatedby",
        'isactive',
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function prospectby()
    {
        return $this->belongsTo(User::class, "createdby", "userid");
    }

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

    public function prospectlost()
    {
        return $this->belongsTo(Types::class, "prospectlostreasonid", "typeid");
    }

    public function prospectownerusers()
    {
        return $this->belongsTo(User::class, "prospectowner", "userid");
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

    public function prospectcustomfield()
    {
        return $this->hasMany(ProspectCustomField::class, "prospectid", "prospectid");
    }

    public function prospectlostreason()
    {
        return $this->belongsTo(Types::class, "prospectlostreasonid", "typeid");
    }
}
