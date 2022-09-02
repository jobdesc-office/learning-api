<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;
use History;
use Log;

class ProspectActivity extends DefaultModel
{
    protected $table = "trprospectactivity";
    protected $primaryKey = "prospectactivityid";

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'prospectactivitylatitude' => 'double',
        'prospectactivitylongitude' => 'double',
    ];

    protected $fillable = [
        "prospectactivityprospectid",
        "prospectactivitycatid",
        "prospectactivitytypeid",
        "prospectactivitydate",
        "prospectactivitydesc",
        "prospectactivityinfo",
        "prospectactivityloc",
        "prospectactivitylatitude",
        "prospectactivitylongitude",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $alias = [
        "prospectactivityprospectid" => "Prospect Id",
        "prospectactivitycatid" => "Category Id",
        "prospectactivitytypeid" => "Type Id",
        "prospectactivitydate" => "Date",
        "prospectactivitydesc" => "Description",
        "prospectactivityinfo" => "Info",
        "prospectactivityloc" => "Location",
        "prospectactivitylatitude" => "Latitude",
        "prospectactivitylongitude" => "Longitude",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function prospectactivityprospect()
    {
        return $this->belongsTo(Prospect::class, 'prospectactivityprospectid', 'prospectid');
    }

    public function prospectactivitycat()
    {
        return $this->belongsTo(Types::class, 'prospectactivitycatid', 'typeid');
    }

    public function prospectactivitytype()
    {
        return $this->belongsTo(Types::class, 'prospectactivitytypeid', 'typeid');
    }
}
