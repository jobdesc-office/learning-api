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
        "userdttypeid",
        "userdtbpid",
        "userdtbranchnm",
        "userdtreferalcode",
        "userdtrelationid",
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
}
