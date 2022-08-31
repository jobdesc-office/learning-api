<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;
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

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public static function boot()
    {
        static::creating(function ($model) {
            Log::info("new Value: " . $model->prospectactivitydesc);
            $old = ProspectActivity::find($model->prospectactivityid);
            Log::info($old);
            // Log::info("old Value: " . $old['prospectactivitydesc']);
        });

        static::updating(function ($model) {
            Log::info($model);
        });

        static::deleting(function ($model) {
            Log::info($model);
        });

        parent::boot();
    }

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
