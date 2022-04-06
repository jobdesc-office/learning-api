<?php

namespace App\Services\Masters;

use App\Models\Masters\Types;
use Illuminate\Support\Facades\DB;

class TypeChildrenServices extends Types
{
    public function datatables($id)
    {
        return $this->newQuery()->select('*')->where('typemasterid', $id);
    }

    public function datatabless()
    {
        return $this->newQuery()->select('*');
    }

    public function parent()
    {
        return $this->newQuery()->select('*')->where('typemasterid', null)->get();
    }
}
