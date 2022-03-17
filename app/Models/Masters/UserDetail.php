<?php

namespace App\Models\Masters;

use App\Models\BusinessPartners\BusinessPartner;
use Database\Factories\UserDetailFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $table = "msuserdt";
    protected $primaryKey = "userdtid";

    protected $fillable = [
        "userid",
        "usertypeid",
        "bpid",
        "branchid",
        "deptid",
        "referalcode",
        "relationid",
        "createdby",
        "updatedby",
        "isactive"
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    protected static function newFactory()
    {
        return new UserDetailFactory();
    }

    public function usertype()
    {
        return $this->hasOne(Types::class, 'typeid', 'usertypeid');
    }

    public function businesspartner()
    {
        return $this->hasOne(BusinessPartner::class, 'bpid', 'bpid');
    }
}
