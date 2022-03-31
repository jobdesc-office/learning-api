<?php

namespace App\Models\Masters;

use App\Models\Masters\Types;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = "vtschedule";
    protected $primaryKey = "scheid";

    protected $fillable = [
        "schenm",
        "schestartdate",
        "scheenddate",
        "schestarttime",
        "scheendtime",
        "schetypeid",
        "scheactdate",
        "schetowardid",
        "schebpid",
        "schereftypeid",
        "scherefid",
        "scheallday",
        "scheloc",
        "scheprivate",
        "scheonline",
        "schetz",
        "scheremind",
        "schedesc",
        "scheonlink",
        "createdby",
        "updatedby",
        'isactive'
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function schetype()
    {
        return $this->hasOne(Types::class, 'typeid', 'schetypeid');
    }

    public function businesspartner()
    {
        return $this->hasOne(BusinessPartner::class, 'bpid', 'schebpid');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'userid', 'schetowardid');
    }

    public function schereftype()
    {
        return $this->hasOne(Types::class, 'typeid', 'schereftypeid');
    }
}
