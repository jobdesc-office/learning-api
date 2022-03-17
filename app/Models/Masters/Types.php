<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Types extends Model
{
    protected $table = "mstype";
    protected $primaryKey = "typeid";

    protected $fillable = [
        "typecd",
        "typename",
        "typeseq",
        "masterid",
        "descriptions",
        "createdby",
        "updatedby"
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function parent()
    {
        return $this->hasOne(Types::class, 'typeid', 'masterid');
    }
}
