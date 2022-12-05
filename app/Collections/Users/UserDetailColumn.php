<?php

namespace App\Collections\Users;

use App\Collections\BusinessPartner\BusinessPartnerCollection;
use App\Collections\BusinessPartner\BusinessPartnerColumn;
use App\Collections\Collection;
use App\Collections\Types\TypeColumn;

class UserDetailColumn extends Collection
{

    public function getId()
    {
        return $this->get('userdtid');
    }

    public function getUserId()
    {
        return $this->get('userid');
    }

    public function getUserTypeId()
    {
        return $this->get('userdttypeid');
    }

    public function userType()
    {
        if ($this->hasNotEmpty('usertype'))
            return new TypeColumn($this->get('usertype'));

        return new TypeColumn();
    }

    public function businessPartner()
    {
        if ($this->hasNotEmpty('businesspartner'))
            return new BusinessPartnerColumn($this->get('businesspartner'));

        return new BusinessPartnerColumn();
    }

    public function securitygroup()
    {
        return $this->get('securitygroup');
    }
}
