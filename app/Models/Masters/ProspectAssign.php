<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class ProspectAssign extends DefaultModel
{
    protected $table = "trprospectassign";
    protected $primaryKey = "prospectassignid";

    protected $fillable = [
        "prospectid",
        "prospectassignto",
        "prospectreportto",
        "prospectassigndesc",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $alias = [
        "prospectid" => "Prospect Id",
        "prospectassignto" => "Assign To",
        "prospectreportto" => "Report To",
        "prospectassigndesc" => "Description",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function prospectassign()
    {
        return $this->belongsTo(UserDetail::class, "prospectassignto", "userdtid");
    }

    public function prospectreport()
    {
        return $this->belongsTo(UserDetail::class, "prospectreportto", "userdtid");
    }

    public function prospectassignss()
    {
        return $this->belongsTo(User::class, "prospectassignto", "userid");
    }

    public function prospectreportss()
    {
        return $this->belongsTo(User::class, "prospectreportto", "userid");
    }

    public function prospect()
    {
        return $this->belongsTo(Prospect::class, "prospectid", "prospectid");
    }

    public function prospectassigncreatedby()
    {
        return $this->belongsTo(User::class, "createdby", "userid");
    }

    public function prospectassignupdatedby()
    {
        return $this->belongsTo(User::class, "updatedby", "userid");
    }
}
