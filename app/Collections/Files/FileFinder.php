<?php

namespace App\Collections\Files;

use App\Models\Masters\Files;

class FileFinder
{
   /**
    * Model dari table mstype
    *
    * @var Files
    * */
   protected $model;

   /**
    * Id Type file dari mstype
    *
    * @var int
    * */
   protected $transtypeid;

   /**
    * id referensi file, data pemilik file
    *
    * @var int
    * */
   protected $refid;

   /**
    * Data collection array type
    *
    * @var FileCollection
    * */
   protected $items;


   public function __construct($transtypeid, $refid)
   {
      $this->model = new Files();
      $this->refid = $refid;
      $this->transtypeid = $transtypeid;

      $items = $this->model->where(['transtypeid' => $transtypeid, 'refid' => $refid])->get();
      $this->items = new FileCollection($items);
   }

   /**
    * @return FileColumn[]
    * */
   public function all()
   {
      return $this->items->all();
   }

   /**
    * @param string|null $keyValue
    * @param callable|null $callback
    * @return FileColumn
    *
    * @throws \Exception
    */
   public function get($keyValue = null, $callback = null)
   {
      if (!is_null($callback) && $this->items->count() == 0)
         return call_user_func_array($callback, [$keyValue]);

      else if (is_null($callback) && $this->items->count() == 0)
         throw new \Exception("Finder tidak menemukan data {$keyValue}");

      if (is_null($keyValue))
         $keyValue = $this->keys->first();

      $data = $this->items->filter(function ($data) use ($keyValue) {
         return $data->get($this->key) == $keyValue;
      });

      if (!is_null($callback) && $data->count() == 0)
         return call_user_func_array($callback, [$keyValue]);

      else if (is_null($callback) && $data->count() == 0)
         throw new \Exception("Data tipe {$keyValue} tidak ditemukan");

      return $data->first();
   }

   /**
    * @return FileColumn[]
    * *@throws \Exception
    * @var string|null $keyValue
    */
   public function getArray($keyValue = null)
   {
      if (is_null($keyValue))
         $keyValue = $this->keys->first();

      $data = $this->items->filter(function ($data) use ($keyValue) {
         return $data->get($this->key) == $keyValue;
      });

      return $data->toArray();
   }
}
