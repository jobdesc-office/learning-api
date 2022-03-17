<?php

namespace App\Collections\Users;

use App\Collections\Collection;
use Illuminate\Support\Facades\Hash;

class UserColumn extends Collection
{

    public function getId()
    {
        return $this->get('userid');
    }

    public function getFullName()
    {
        return $this->get('userfullname');
    }

    public function getPassword()
    {
        return $this->get('userpassword');
    }

    public function checkPassword($pasword)
    {
        return Hash::check($pasword, $this->getPassword());
    }

    public function getEmail()
    {
        return $this->get('useremail');
    }

    public function getPhone()
    {
        return $this->get('userphone');
    }

    public function getUserDeviceId()
    {
        return $this->get('userdeviceid');
    }

    public function userDetail()
    {
        if($this->hasNotEmpty('userdetails'))
            return new UserDetailCollection($this->get('userdetails'));

        return new UserDetailCollection([]);
    }
}
