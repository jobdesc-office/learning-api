<?php

namespace App\Models\BusinessPartners;

use Database\Factories\BusinessPartnerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessPartner extends Model
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
        "isactive"
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    protected static function newFactory() {
        return BusinessPartnerFactory::new();
    }
}
