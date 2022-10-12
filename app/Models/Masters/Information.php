<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class Information extends DefaultModel
{

    protected $table = "msinformation";
    protected $primaryKey = "infoid";

    protected $fillable = [
        "infoname",
        "infodesc",
        "infotypeid",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $alias = [
        'infoname' => "Name",
        'infotypeid' => "Information Type",
        'infodesc' => "Description",
        "createdby" => "Craeted By",
        "updatedby" => "Updated By",
        'isactive' => "Is Active",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function infotype()
    {
        return $this->belongsTo(Types::class, 'infotypeid', 'typeid');
    }

    public function infocreatedby()
    {
        return $this->belongsTo(User::class, "createdby", "userid");
    }

    public function infoupdatedby()
    {
        return $this->belongsTo(User::class, "updatedby", "userid");
    }
}
