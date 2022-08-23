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
                $query->select('menuid', 'menunm', 'menuroute');
            }, 'feature' => function ($query) {
                $query->select('featid', 'feattitle', 'featslug');
            }])
            ->where('roleid', $roleid)
            ->get();
    }
}
