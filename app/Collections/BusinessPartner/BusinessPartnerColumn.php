<?php

namespace App\Collections\BusinessPartner;

use App\Collections\Collection;

class BusinessPartnerColumn extends Collection
{

    public function getId()
    {
        return $this->get('userdtbpid');
    }

    public function getName()
    {
        return $this->get('bpname');
    }
}