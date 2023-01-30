<?php

namespace App\Models\Masters;

use App\Models\Masters\BusinessPartner;
use Database\Factories\UserDetailFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DefaultModel;

class UserDetail extends DefaultModel
{
    use HasFactory;

    protected $table = "msuserdt";
    protected $primaryKey = "userdtid";

    protected $fillable = [
        "userid",
        "userdttypeid",
        "userdtbpid",
        "userdtbranchnm",
        "userdtreferalcode",
        "userdtrelationid",
        "userdtsgid",
        "createdby",
        "updatedby",
        "isactive"
    ];

    protected $alias = [
        "userid" => "User Id",
        "userdttypeid" => "Type Id",
        "userdtbpid" => "Business Partner Id",
        "userdtbranchnm" => "Branch Name",
        "userdtreferalcode" => "Referal Code",
        "userdtrelationid" => "Relation Id",
        "userdtsgid" => "Security Group Id"
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    protected static function newFactory()
    {
        return new UserDetailFactory();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userid', 'userid');
    }

    public function usertype()
    {
        return $this->belongsTo(Types::class, 'userdttypeid', 'typeid');
    }

    public function businesspartner()
    {
        return $this->belongsTo(BusinessPartner::class, 'userdtbpid', 'bpid');
    }

    public function securitygroup()
    {
        return $this->belongsTo(SecurityGroup::class, 'userdtsgid', 'sgid');
    }
}
