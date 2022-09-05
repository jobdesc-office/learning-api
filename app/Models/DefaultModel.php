<?php

namespace App\Models;

use DateTimeInterface;
use History;
use Illuminate\Database\Eloquent\Model;
use Log;

class DefaultModel extends Model
{
   protected $alias = [];
   protected static $history = true;

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
         if (static::$history) {
            $old = new static();
            $old = $old->find($model->getId());
            $history = new History($old, $model);
            $history->store();
         }
      });

      static::created(function ($model) {
         if (static::$history) {
            $old = new static();
            $old->setAttribute($old->primaryKey, $model->getId());
            $history = new History($old, $model, true, "FIELD value has been created at DATE by USER");
            $history->store();
         }
      });

      static::deleted(function ($model) {
         if (static::$history) {
            $old = new static();
            $old->setAttribute($old->primaryKey, $model->getId());
            $history = new History($old, $model, true, "FIELD value has been deleted at DATE by USER");
            $history->store();
         }
      });

      parent::boot();
   }
}
