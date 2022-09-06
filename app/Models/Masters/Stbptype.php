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
        "sbttypemasterid",
        "sbttypename",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $alias = [
        "sbtbpid" => "Business Partner Id",
        "sbtname" => "Name",
        "sbtseq" => "Sequel",
        "sbttypemasterid" => "Type Id",
        "sbttypename" => "Type Name",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function stbptypetype()
    {
        return $this->belongsTo(Types::class, 'sbttypemasterid', 'typeid');
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
