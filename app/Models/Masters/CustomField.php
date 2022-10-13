<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class CustomField extends DefaultModel
{
    protected $table = "vtcustomfield";
    protected $primaryKey = "custfid";

    protected $fillable = [
        "custfbpid",
        "custfname",
        "custftypeid",
        "alldata",
        "onlythisdata",
        "thisdataid",
        "custfreftypeid",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $alias = [
        "custfbpid" => "",
        "custfname" => "",
        "custftypeid" => "",
        "alldata" => "",
        "onlythisdata" => "",
        "thisdataid" => "",
        "custfreftypeid" => "",
        "createdby" => "",
        "updatedby" => "",
        'isactive' => "",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function businesspartner()
    {
        return $this->belongsTo(BusinessPartner::class, 'custfbpid', 'bpid');
    }

    public function selectoption()
    {
        return $this->hasMany(Option::class, 'optcustfid', 'custfid');
    }

    public function refprospect()
    {
        return $this->belongsTo(Prospect::class, 'thisdataid', 'prospectid');
    }

    public function refactivity()
    {
        return $this->belongsTo(DailyActivity::class, 'thisdataid', 'dayactid');
    }

    public function custftype()
    {
        return $this->belongsTo(Types::class, 'custftypeid', 'typeid');
    }

    public function custfreftype()
    {
        return $this->belongsTo(Types::class, 'custfreftypeid', 'typeid');
    }

    public function custfcreatedby()
    {
        return $this->belongsTo(User::class, "createdby", "userid");
    }

    public function custfupdatedby()
    {
        return $this->belongsTo(User::class, "updatedby", "userid");
    }
}
