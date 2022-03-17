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
                'parent' => function($query) {
                    $query->select('menuid', 'menunm');
                }
            ])
            ->where(function($query) use ($searchValue) {
                $query->where(DB::raw('TRIM(LOWER(menunm))'), 'like', "%$searchValue%")
                    ->orWhereHas('parent', function($query) use ($searchValue) {
                        $query->where(DB::raw('TRIM(LOWER(menunm))'), 'like', "%$searchValue%");
                    });
            })
            ->get();
    }

    public function datatables()
    {
        return $this->newQuery()
            ->with([
                'menutype' => function($query) {
                    $query->select('typeid', 'typename');
                }
            ]);
    }

    public function find($id)
    {
        return $this->newQuery()->select('menuid', 'menutypeid', 'menunm', 'masterid', 'icon', 'route', 'color', 'seq')
            ->with([
                'parent' => function($query) {
                    $query->select('menuid', 'menunm');
                },
                'menutype' => function($query) {
                    $query->select('typeid', 'typename');
                }
            ])
            ->findOrFail($id);
    }
}
