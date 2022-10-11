<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class Product extends DefaultModel
{
    protected $table = "msproduct";
    protected $primaryKey = "productid";

    protected $fillable = [
        "productname",
        "productbpid",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $alias = [
        "productname" => "Name",
        "productbpid" => "Business Partner Id",
        "createdby" => "Craeted By",
        "updatedby" => "Updated By",
        'isactive' => "Is Active",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function businesspartner()
    {
        return $this->belongsTo(BusinessPartner::class, 'productbpid', 'bpid');
    }

    public function productcreatedby()
    {
        return $this->belongsTo(User::class, "createdby", "userid");
    }

    public function productupdatedby()
    {
        return $this->belongsTo(User::class, "updatedby", "userid");
    }
}
