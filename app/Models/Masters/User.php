<?php

namespace App\Models\Masters;

use Database\Factories\UserFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DefaultModel;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends DefaultModel implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use HasFactory, Authorizable, Authenticatable;

    protected $table = "msuser";
    protected $primaryKey = "userid";

    protected $fillable = [
        'username',
        'userpassword',
        'userfullname',
        'useremail',
        'userphone',
        'userdeviceid',
        'userfcmtoken',
        'usersocketid',
        'createdby',
        'updatedby',
        'isactive',
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    protected static function newFactory()
    {
        return new UserFactory();
    }

    /**
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @inheritDoc
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAuthPassword()
    {
        return $this->userpassword;
    }

    public function userdetails()
    {
        return $this->hasMany(UserDetail::class, 'userid', 'userid');
    }

    public function userActivity()
    {
        return $this->hasMany(DailyActivity::class, 'createdby', 'userid');
    }
}
