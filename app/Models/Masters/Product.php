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
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function businesspartner()
    {
        return $this->belongsTo(BusinessPartner::class, 'productbpid', 'bpid');
    }
}
