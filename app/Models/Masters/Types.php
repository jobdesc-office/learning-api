<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class Types extends DefaultModel
{
    protected $table = "mstype";
    protected $primaryKey = "typeid";

    protected $fillable = [
        "typecd",
        "typename",
        "typeseq",
        "typemasterid",
        "typedesc",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $alias = [
        "typecd" => "Code",
        "typename" => "Name",
        "typeseq" => "Sequence",
        "typemasterid" => "Master Id",
        "typedesc" => "Description",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function parent()
    {
        return $this->belongsTo(Types::class, 'typemasterid', 'typeid');
    }

    public function childrens()
    {
        return $this->hasMany(Types::class, 'typeid', 'typemasterid',);
    }

    public function typecreatedby()
    {
        return $this->belongsTo(User::class, "createdby", "userid");
    }

    public function typeupdatedby()
    {
        return $this->belongsTo(User::class, "updatedby", "userid");
    }
}
