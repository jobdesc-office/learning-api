<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class Village extends DefaultModel
{
    protected $table = "msvillage";
    protected $primaryKey = "villageid";

    protected $fillable = [
        "villagesubdistrictid",
        "villagename",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $alias = [
        "villagesubdistrictid" => "Subdistrict Id",
        "villagename" => "Name",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function villagesubdistrict()
    {
        return $this->belongsTo(Subdistrict::class, 'villagesubdistrictid', 'subdistrictid');
    }
}
