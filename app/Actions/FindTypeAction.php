<?php

namespace App\Actions;

use App\Collections\Types\TypeFinder;
use App\Services\TypeServices;

class FindTypeAction
{

    static private $instance;

    static public function find()
    {
        if (is_null(self::$instance))
            self::$instance = new FindTypeAction();

        return self::$instance;
    }

    /* @var TypeServices */
    protected $service;

    public function __construct()
    {
        $this->service = new TypeServices();
    }

    public function in($code)
    {
        $codes = is_array($code) ? $code : func_get_args();

        $types = $this->service->newQuery()->whereIn('typecd', $codes)
            ->get();

        return new TypeFinder('typecd', $code, $types);
    }

    public function byCode($code)
    {
        $codes = is_array($code) ? $code : func_get_args();

        $types = $this->service->whereParent($codes)
            ->get();
        return new TypeFinder('typecd', $code, $types->toArray());
    }
}
