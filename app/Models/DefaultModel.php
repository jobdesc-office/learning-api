<?php

namespace App\Models;

use DateTimeInterface;
use History;
use Illuminate\Database\Eloquent\Model;

class DefaultModel extends Model
{
   protected $alias = [];

   protected function serializeDate(DateTimeInterface $date)
   {
      return $date->format('Y-m-d H:i:s');
   }

   /**
    * @return string
    */
   public function getAlias($fieldName)
   {
      return $this->alias[$fieldName];
   }

   public function getId()
   {
      return $this->getAttribute($this->primaryKey);
   }

   public static function boot()
   {
      static::updating(function ($model) {
         $old = new static([$model->primaryKey => $model->getId()]);
         $old = $old->get()->first();

         $history = new History($old, $model);
         $history->store();
      });

      parent::boot();
   }
}
