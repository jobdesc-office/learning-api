<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class ProspectCustomField extends DefaultModel
{
    protected $table = "trprospectcf";
    protected $primaryKey = "prospectcfid";

    protected $fillable = [
        "prospectid",
        "prospectcustfid",
        "prospectcfvalue",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $alias = [
        "prospectid" => "Prospect Id",
        "prospectcustfid" => "Custom Field Id",
        "prospectcfvalue" => "Custom Field Value",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function prospect()
    {
        return $this->belongsTo(Prospect::class, "prospectid", "prospectid");
    }

    public function customfield()
    {
        return $this->belongsTo(CustomField::class, 'prospectcustfid', 'custfid');
    }
}
