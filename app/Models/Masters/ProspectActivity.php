<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class ProspectActivity extends Model
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
        "prospectactivityloc",
        "prospectactivitylatitude",
        "prospectactivitylongitude",
        "createdby",
        "updatedby",
        'isactive',
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
