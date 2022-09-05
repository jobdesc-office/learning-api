<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class Subdistrict extends DefaultModel
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

    protected $alias = [
        "subdistrictcityid" => "City Id",
        "subdistrictname" => "Name",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function subdistrictcity()
    {
        return $this->belongsTo(City::class, 'subdistrictcityid', 'cityid');
    }

    public function subdistrictcreatedby()
    {
        return $this->belongsTo(User::class, "createdby", "userid");
    }

    public function subdistrictupdatedby()
    {
        return $this->belongsTo(User::class, "updatedby", "userid");
    }
}
