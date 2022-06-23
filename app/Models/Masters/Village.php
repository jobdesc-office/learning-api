<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
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

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function villagesubdistrict()
    {
        return $this->belongsTo(Subdistrict::class, 'villagesubdistrictid', 'subdistrictid');
    }
}
