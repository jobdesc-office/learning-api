<?php

namespace App\Models\Security;

use App\Models\DefaultModel;

class Permission extends DefaultModel
{
    protected $table = "mspermission";
    protected $primaryKey = "permisid";

    protected $fillable = [
        "roleid",
        "permismenuid",
        "permisfeatid",
        "hasaccess",
        "createdby",
        "updatedby",
        'isactive',
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function role()
    {
        return $this->belongsTo(Types::class, 'roleid', 'typeid');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'permismenuid', 'menuid');
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class, 'permisfeatid', 'menuid');
    }
}
