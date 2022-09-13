<?php

namespace App\Collections\Types;

use App\Collections\Collection;

class TypeColumn extends Collection
{

    public function getId()
    {
        return $this->get('typeid');
    }

    public function getName()
    {
        return $this->get('typename');
    }

    public function getChildrenId()
    {
        return $this->get('sbtid');
    }

    public function getChildrenName()
    {
        return $this->get('sbttypename');
    }

    public function getCode()
    {
        return $this->get('typecd');
    }

    public function getSequence()
    {
        return $this->get('typeseq');
    }

    public function getDesc()
    {
        return $this->get('description');
    }

    public function getParentId()
    {
        return $this->get('typemasterid');
    }

    public function parent()
    {
        if ($this->hasNotEmpty('parent'))
            return new TypeColumn($this->get('parent'));

        return new TypeColumn();
    }
}
