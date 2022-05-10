<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    protected $table = "mssubdistrict";
    protected $primaryKey = "subdistrictid";

    protected $fillable = [
        "subdistrictcityid",
        "subdistrictname",
        "createdby",
        "updatedby",
        'isactive',
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function subdistrictcity()
    {
        $this->belongsTo(City::class, 'subdistrictcityid', 'cityid');
    }
}
