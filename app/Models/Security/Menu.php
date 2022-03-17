<?php

namespace App\Models\Security;

use App\Models\Masters\Types;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $table = "msmenu";
    protected $primaryKey = "menuid";

    protected $fillable = [
        "masterid",
        "menutypeid",
        "menunm",
        "icon",
        "route",
        "color",
        "seq",
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
}
