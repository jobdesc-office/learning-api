<?php

namespace App\Services\Masters;

use App\Collections\Files\FileUploader;
use App\Models\Masters\Competitor;
use DBTypes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompetitorServices extends Competitor
{
   public function find($id)
   {
      return $this->getQuery()->findOrFail($id);
   }

   public function store(Collection $insert)
   {
      $this->fill($insert->toArray())->save();
      if ($insert->has('comptpics')) {
         foreach ($insert->get('comptpics') as  $file) {
            $temp_path = $file->getPathname();
            $filename = Str::replace(['/', '\\'], '', Hash::make(Str::random())) . $file->getClientOriginalExtension();

            $comptpic = find_type()->in([DBTypes::comppics])->get(DBTypes::comppics)->getId();
            $file = new FileUploader($temp_path, $filename, 'images/', $comptpic, $this->comptid);
            $file->upload();
         }
      }
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
