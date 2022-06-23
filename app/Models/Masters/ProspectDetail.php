<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class ProspectDetail extends Model
{
    protected $table = "trprospectdt";
    protected $primaryKey = "prospectdtid";

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'prospectdtlatitude' => 'double',
        'prospectdtlongitude' => 'double',
    ];

    protected $fillable = [
        "prospectdtprospectid",
        "prospectdtcatid",
        "prospectdttypeid",
        "prospectdtdate",
        "prospectdtdesc",
        "prospectdtloc",
        "prospectdtlatitude",
        "prospectdtlongitude",
        "createdby",
        "updatedby",
        'isactive',
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function prospectdtprospect()
    {
        return $this->belongsTo(Prospect::class, 'prospectdtprospectid', 'prospectid');
    }

    public function prospectdtcat()
    {
        return $this->belongsTo(Types::class, 'prospectdtcatid', 'typeid');
    }

    public function prospectdttype()
    {
        return $this->belongsTo(Types::class, 'prospectdttypeid', 'typeid');
    }
}
