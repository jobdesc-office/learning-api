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
        "allprospect",
        "onlythisprospect",
        "thisprospectid",
        "createdby",
        "updatedby",
        'isactive',
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function businesspartner()
    {
        return $this->belongsTo(BusinessPartner::class, 'custfbpid', 'bpid');
    }

    public function custftype()
    {
        return $this->belongsTo(Types::class, 'custftypeid', 'typeid');
    }
}
