<?php

namespace App\Services\Security;

use App\Models\Security\Permission;
use Illuminate\Support\Facades\DB;

class PermissionServices extends Permission
{

    public function permission(int $roleid)
    {
        return $this->newQuery()->select('permisid', 'permismenuid', 'permisfeatid', 'hasaccess')
            ->orderBy('permisfeatid', 'asc')
            ->with(['menu' => function ($query) {
                $query->select('*');
            }, 'feature' => function ($query) {
                $query->select('*');
            }])
            ->where('roleid', $roleid)
            ->get();
    }

    public function updateAccsess($menufeatid, $roleid)
    {
        return $this->newQuery()->select('*')->where('roleid', $roleid)->where('permisfeatid', $menufeatid)->get();
    }
}
