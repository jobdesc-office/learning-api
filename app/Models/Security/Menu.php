<?php

namespace App\Models\Security;

use App\Models\Masters\Types;
use App\Models\DefaultModel;

class Menu extends DefaultModel
{

    protected $table = "msmenu";
    protected $primaryKey = "menuid";

    protected $fillable = [
        "masterid",
        "menutypeid",
        "menunm",
        "menuicon",
        "menuroute",
        "menucolor",
        "menuseq",
        "createdby",
        "updatedby",
        "isactive",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function menutype()
    {
        return $this->hasOne(Types::class, 'typeid', 'menutypeid');
    }

    public function parent()
    {
        return $this->hasOne(Menu::class, 'menuid', 'masterid');
    }

    public function features()
    {
        return $this->hasMany(Feature::class, 'featmenuid', 'menuid');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'masterid', 'menuid');
    }
}
