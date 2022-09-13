<?php

namespace App\Actions;

use App\Collections\BpTypes\BpTypeFinder;
use App\Services\TypeServices;

class FindBpTypeAction
{

    static private $instance;

    static public function find()
    {
        if (is_null(self::$instance))
            self::$instance = new FindBpTypeAction();

        return self::$instance;
    }

    /* @var BpTypeServices */
    protected $service;

    public function __construct()
    {
        $this->service = new TypeServices();
    }

    public function in($code)
    {
        $codes = is_array($code) ? $code : func_get_args();

        $BpTypes = $this->service->newQuery()->whereIn('typecd', $codes)
            ->get();

        return new BpTypeFinder('typecd', $code, $BpTypes);
    }

    public function byCode($code)
    {
        $codes = is_array($code) ? $code : func_get_args();

        $BpTypes = $this->service->whereParent($codes)
            ->get();
        return new BpTypeFinder('typecd', $code, $BpTypes->toArray());
    }
}
