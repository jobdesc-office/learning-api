<?php

namespace App\Models\Masters;

use App\Models\Masters\Types;
use Database\Factories\BusinessPartnerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DefaultModel;

class BusinessPartner extends DefaultModel
{
    use HasFactory;

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

    protected static function newFactory()
    {
        return BusinessPartnerFactory::new();
    }

    public function bptype()
    {
        return $this->belongsTo(Types::class, 'bptypeid', 'typeid');
    }

    public function userdetail()
    {
        return $this->hasMany(UserDetail::class, 'userdtbpid', 'bpid');
    }
}
