<?php

namespace App\Services;

use App\Models\Masters\User;
use Illuminate\Database\Eloquent\Model;

class AuthServices extends User
{

    public function authQuery()
    {
        return $this->newQuery()->select(['userid', 'username', 'userpassword', 'userfullname', 'useremail', 'userphone', 'userdeviceid'])
            ->with([
                'userdetails' => function ($query) {
                    $query->select('userid', 'userdtid', 'userdttypeid', 'userdtbpid')
                        ->with([
                            'usertype' => function ($query) {
                                $query->select('typeid', 'typename', 'typecd');
                            },
                            'businesspartner' => function ($query) {
                                $query->select('bpid', 'bpname');
                            }
                        ]);
                }
            ])
            ->where('isactive', true);
    }

    /**
     * @return User|Model
     * */
    public function authUserNameOrEmail($value)
    {
        return $this->authQuery()->where(function ($query) use ($value) {
            $query->where('username', $value)
                ->orWhere('useremail', $value);
        })->first();
    }
}
