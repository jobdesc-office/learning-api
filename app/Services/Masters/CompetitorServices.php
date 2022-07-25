<?php

namespace App\Services\Masters;

use App\Collections\Files\FileColumn;
use App\Collections\Files\FileFinder;
use App\Collections\Files\FileUploader;
use App\Models\Masters\Competitor;
use App\Models\Masters\Files;
use DBTypes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompetitorServices extends Competitor
{

   public function select($searchValue)
   {
      return $this->getQuery()->select('*')
         ->where(function ($query) use ($searchValue) {
            $searchValue = trim(strtolower($searchValue));
            $query->where(DB::raw('TRIM(LOWER(comptname))'), 'like', "%$searchValue%");
         })
         ->orderBy('comptname', 'asc')
         ->get();
   }

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

   public function store(Collection $insert)
   {
      $this->fill($insert->toArray())->save();
      if ($insert->has('comptpics')) {
         $comptpic = find_type()->in([DBTypes::comppics])->get(DBTypes::comppics)->getId();
         foreach ($insert->get('comptpics') as  $file) {
            $temp_path = $file->getPathname();
            $filename = Str::replace(['/', '\\'], '', Hash::make(Str::random())) . '.' . $file->getClientOriginalExtension();

            $file = new FileUploader($temp_path, $filename, 'images/', $comptpic, $this->comptid);
            $file->upload();
         }
      }
   }

   public function edit($id, Collection $insert)
   {
      $competitor = $this->find($id)->fill($insert->toArray());
      $competitor->save();

      if ($insert->has('comptpics')) {
         $comptpic = find_type()->in([DBTypes::comppics])->get(DBTypes::comppics)->getId();

         $files = new FileFinder($comptpic, $competitor->comptid);
         $ids = collect($files->all())->map(function (FileColumn $item) {
            return $item->getId();
         });

         $files = Files::whereIn('fileid', $ids->toArray())->get();
         foreach ($files as $file) {
            $file->delete();
         }

         foreach ($insert->get('comptpics') as  $file) {
            $temp_path = $file->getPathname();
            $filename = Str::replace(['/', '\\'], '', Hash::make(Str::random()));

            $file = new FileUploader($temp_path, $filename, 'images/', $comptpic, $competitor->comptid);
            $file->upload();
         }
      }
   }

   public function getAll(Collection $whereArr)
   {
      $query = $this->getQuery();

      $competitorWhere = $whereArr->only($this->fillable);
      if ($competitorWhere->isNotEmpty()) {
         $query->where($competitorWhere->toArray());
      }

      return $query->get();
   }

   public function getQuery()
   {
      return $this->newQuery()->with([
         'comptreftype' => function ($query) {
            $query->select('typeid', 'typename');
         },
         'comptbp',
         'comptpics' => function ($query) {
            $query->addSelect(DB::raw("*,concat('" . url('storage') . "', '/', \"directories\", '',\"filename\") as url"))
               ->whereHas('transtype', function ($query) {
                  $query->where('typecd', DBTypes::comppics);
               });
         },
      ]);
   }
}
