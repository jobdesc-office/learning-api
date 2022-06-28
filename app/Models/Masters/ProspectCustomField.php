<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class ProspectCustomField extends Model
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
