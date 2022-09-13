<?php

namespace App\Collections\BpTypes;

use App\Collections\Collection;

class BpTypeColumn extends Collection
{

    public function getId()
    {
        return $this->get('sbtid');
    }

    public function getName()
    {
        return $this->get('sbttypename');
    }

    public function getCode()
    {
        return $this->get('sbtname');
    }

    public function getSequence()
    {
        return $this->get('sbtseq');
    }

    public function getDesc()
    {
        return $this->get('sbtremark');
    }

    public function getParentId()
    {
        return $this->get('sbttypemasterid');
    }

    public function parent()
    {
        if ($this->hasNotEmpty('parent'))
            return new BpTypeColumn($this->get('parent'));

        return new BpTypeColumn();
    }
}
