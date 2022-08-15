<?php

namespace App\Models\Security;

use App\Models\DefaultModel;

class Feature extends DefaultModel
{

    protected $table = "msfeature";
    protected $primaryKey = "featid";

    protected $fillable = [
        "featmenuid",
        "feattitle",
        "featslug",
        "featuredesc",
        "createdby",
        "updatedby",
        "isactive",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function menu()
    {
        return $this->hasOne(Menu::class, 'menuid', 'featmenuid');
    }
}
