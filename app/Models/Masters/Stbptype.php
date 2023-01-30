<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class Stbptype extends DefaultModel
{
    protected $table = "stbptype";
    protected $primaryKey = "sbtid";

    protected $fillable = [
        "sbtbpid",
        "sbtname",
        "sbtseq",
        "sbtsgid",
        "sbttypemasterid",
        "sbttypename",
        "sbtremark",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $alias = [
        "sbtsgid" => "Security Group Id",
        "sbtbpid" => "Business Partner Id",
        "sbtname" => "Name",
        "sbtseq" => "Sequel",
        "sbttypemasterid" => "Type Id",
        "sbttypename" => "Type Name",
        "sbtremark" => "Marker",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function stbptypetype()
    {
        return $this->belongsTo(Types::class, 'sbttypemasterid', 'typeid');
    }

    public function securitygroup()
    {
        return $this->belongsTo(SecurityGroup::class, 'sbtsgid', 'sgid');
    }

    public function stbptypebp()
    {
        return $this->belongsTo(BusinessPartner::class, 'sbtbpid', 'bpid');
    }

    public function stbptypecreatedby()
    {
        return $this->belongsTo(User::class, "createdby", "userid");
    }

    public function stbptypeupdatedby()
    {
        return $this->belongsTo(User::class, "updatedby", "userid");
    }
}
