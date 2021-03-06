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
                'menutype' => function ($query) {
                    $query->select('typeid', 'typename');
                }
            ])
            ->where(function ($query) use ($search, $order) {
                $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
            })
            ->orderBy($order, $orderby);
    }

    public function find($id)
    {
        return $this->newQuery()->select('menuid', 'menutypeid', 'menunm', 'masterid', 'menuicon', 'menuroute', 'menucolor', 'menuseq')
            ->with([
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
