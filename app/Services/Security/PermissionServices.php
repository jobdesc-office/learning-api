<?php

namespace App\Services\Security;

use App\Models\Security\Permission;
use Illuminate\Support\Facades\DB;

class PermissionServices extends Permission
{

    public function permission(int $roleid, int $menuid)
    {
        return $this->newQuery()->orderBy('permisfeatid', 'asc')
            ->with(['menu' => function ($query) {
                $query->with(['features']);
            }])

            ->join('msmenu', 'mspermission.permismenuid', '=', 'msmenu.menuid')
            // ->where('roleid', $roleid)
            // ->where('permismenuid', $menuid)
            ->get();
    }
}
