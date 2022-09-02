<?php

namespace App\Models\Security;

use App\Models\Masters\User;
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

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'permisfeatid', 'featid');
    }

    public function featcreatedby()
    {
        return $this->belongsTo(User::class, "createdby", "userid");
    }

    public function featupdatedby()
    {
        return $this->belongsTo(User::class, "updatedby", "userid");
    }
}
