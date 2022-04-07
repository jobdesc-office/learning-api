<?php

namespace App\Models\Masters;

use App\Models\Masters\Types;
use Illuminate\Database\Eloquent\Model;

class BusinessPartner extends Model
{
    protected $table = "msbusinesspartner";
    protected $primaryKey = "bpid";

    protected $fillable = [
        "bpname",
        "bptypeid",
        "bppicname",
        "bpemail",
        "bpphone",
        "createdby",
        "updatedby",
        'isactive'
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function bptype()
    {
        return $this->hasOne(Types::class, 'typeid', 'bptypeid');
    }

    public function parent()
    {
        return $this->hasOne(Types::class, 'typeid', 'typemasterid');
    }

    public function userdetail()
    {
        return $this->belongsTo(UserDetail::class, 'bpid', 'userdtbpid');
    }
}
