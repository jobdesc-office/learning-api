<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class ProspectAssign extends Model
{
    protected $table = "trprospectassign";
    protected $primaryKey = "prospectassignid";

    protected $fillable = [
        "prospectid",
        "prospectassignto",
        "prospectreportto",
        "prospectid",
        "prospectassigndesc",
        "createdby",
        "updatedby",
        'isactive',
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

    public function prospect()
    {
        return $this->belongsTo(Prospect::class, "prospectid", "prospectid");
    }
}
