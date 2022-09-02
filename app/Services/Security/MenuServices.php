<?php

namespace App\Services\Security;

use App\Models\Security\Menu;
use Illuminate\Support\Facades\DB;

class MenuServices extends Menu
{

    public function select($searchValue)
    {
        return $this->newQuery()->select('menuid', 'menunm', 'masterid')
            ->with([
                'menucreatedby',
                'menuupdatedby',
                'parent' => function ($query) {
                    $query->select('menuid', 'menunm');
                }
            ])
            ->where(function ($query) use ($searchValue) {
                $query->where(DB::raw('TRIM(LOWER(menunm))'), 'like', "%$searchValue%")
                    ->orWhereHas('parent', function ($query) use ($searchValue) {
                        $query->where(DB::raw('TRIM(LOWER(menunm))'), 'like', "%$searchValue%");
                    });
            })
            ->get();
    }

    public function datatables($order, $orderby, $search)
    {
        return $this->newQuery()
            ->with([
                'menucreatedby',
                'menuupdatedby',
                'menutype' => function ($query) {
                    $query->select('typeid', 'typename');
                }
            ])
            ->where(function ($query) use ($search, $order) {
                $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
            })
            ->orderBy($order, $orderby);
    }

    public function allMenuParent(int $roleid)
    {
        return $this->newQuery()
            ->where('masterid', null)
            ->orderBy('menunm', 'asc')
            ->with([
                'menucreatedby',
                'menuupdatedby',
                'menutype' => function ($query) {
                    $query->select('typeid', 'typename');
                }, 'children' => function ($query) use ($roleid) {
                    $query->orderBy('menunm', 'asc')->with(['features' => function ($query) use ($roleid) {
                        $query->join('mspermission', 'msfeature.featid', '=', 'mspermission.permisfeatid')->where('roleid', $roleid)->orderBy('mspermission.permisfeatid', 'asc');
                    }]);
                },
                'features' => function ($query) use ($roleid) {
                    $query->join('mspermission', 'msfeature.featid', '=', 'mspermission.permisfeatid')->where('roleid', $roleid)->orderBy('mspermission.permisfeatid', 'asc');
                }
            ])
            ->get();
    }

    public function find($id)
    {
        return $this->newQuery()->select('*')
            ->with([
                'menucreatedby',
                'menuupdatedby',
                'parent' => function ($query) {
                    $query->select('menuid', 'menunm');
                },
                'menutype' => function ($query) {
                    $query->select('typeid', 'typename');
                }
            ])
            ->findOrFail($id);
    }
}
