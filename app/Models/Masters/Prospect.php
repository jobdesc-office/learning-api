<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DefaultModel;
use Database\Factories\ProspectFactory;

class Prospect extends DefaultModel
{
    use HasFactory;
    protected $table = "trprospect";
    protected $primaryKey = "prospectid";

    protected static function newFactory()
    {
        return new ProspectFactory();
    }

    protected $fillable = [
        "prospectname",
        "prospectcode",
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
        "prospectcustlabel",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $alias = [
        "prospectname" => "Name",
        "prospectcode" => "Code",
        "prospectstartdate" => "Start Date",
        "prospectenddate" => "End Date",
        "prospectvalue" => "Value",
        "prospectowner" => "Owner",
        "prospectstageid" => "Stage Id",
        "prospectstatusid" => "Status Id",
        "prospectexpclosedate" => "Expectated Close Date",
        "prospectbpid" => "Business Partner Id",
        "prospectdescription" => "Description",
        "prospectcustid" => "Customer Id",
        "prospectrefid" => "Reference Id",
        "prospectlostreasonid" => "Lost Reason Id",
        "prospectlostdesc" => "Lost Description",
        "prospectcustlabel" => "Customer Label",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function prospectby()
    {
        return $this->belongsTo(User::class, "createdby", "userid");
    }

    public function prospectupdatedby()
    {
        return $this->belongsTo(User::class, "updatedby", "userid");
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

    public function prospectcustlabeltype()
    {
        return $this->belongsTo(Types::class, "prospectcustlabel", "typeid");
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

    public function prospectfiles()
    {
        return $this->hasMany(Files::class, 'refid', 'prospectid');
    }
}
