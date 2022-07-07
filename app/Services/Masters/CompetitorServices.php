<?php

namespace App\Services\Masters;

use App\Models\Masters\Competitor;
use Illuminate\Support\Collection;

class CompetitorServices extends Competitor
{
   public function find($id)
   {
      return $this->getQuery()->findOrFail($id);
   }

   public function getAll(Collection $whereArr)
   {
      $query = $this->getQuery();

      $competitorWhere = $whereArr->only($this->fillable);
      if ($competitorWhere->isNotEmpty()) {
         $query = $query->where($competitorWhere->toArray());
      }

      return $query->get();
   }

   public function getQuery()
   {
      return $this->newQuery()->with([
         'comptreftype' => function ($query) {
            $query->select('typeid', 'typename');
         },
         'comptbp'
      ]);
   }
}
