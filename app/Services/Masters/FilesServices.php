<?php

namespace App\Services\Masters;

use App\Models\Masters\Files;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FilesServices extends Files
{

   public function datatables($order, $orderby, $search)
   {
      return $this->getQuery()
         ->where(function ($query) use ($search, $order) {
            $query->where(DB::raw("TRIM(LOWER($order))"), 'like', "%$search%");
         })
         ->orderBy($order, $orderby);
   }

   public function find($id)
   {
      return $this->getQuery()->findOrFail($id);
   }

   public function getAll(Collection $whereArr)
   {
      $query = $this->getQuery();

      $filesWhere = $whereArr->only($this->fillable);
      if ($filesWhere->isNotEmpty()) {
         $query = $query->where($filesWhere->toArray());
      }

      return $query->get();
   }

   /**
    * @return Builder
    */
   public function getQuery()
   {
      return $this->newQuery()->with([
         'transtype' => function ($query) {
            $query->select('typeid', 'typename');
         }
      ])->addSelect(DB::raw("*,concat('" . url('storage') . "', '/', \"directories\", '',\"filename\") as url"));
   }
}
