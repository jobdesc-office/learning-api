<?php

namespace App\Services\Masters;

use App\Models\Masters\Option;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OptionServices extends Option
{
    public function find($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'customizefield',
            'optioncreatedby',
            'optionupdatedby',
        ]);
    }
}
