<?php

namespace App\Collections\Types;

use App\Collections\CollectionFinder;
use App\Models\Masters\Types;

class TypeFinder extends CollectionFinder
{

    public function __construct($key, $keys, $items)
    {
        $this->model = new Types();

        parent::__construct($key, $keys, collect($items)->map(function($data) {
            return new TypeColumn($data);
        }));
    }

    /**
     * @return TypeColumn[]
     * */
    public function all()
    {
        return parent::all();
    }

    /**
     * @param string|null $keyValue
     * @param callable|null $callback
     * @return TypeColumn
     *
     * @throws \Exception
     */
    public function get($keyValue = null, $callback = null)
    {
        return parent::get($keyValue, $callback);
    }

    /**
     * @return TypeColumn[]
     * *@throws \Exception
     * @var string|null $keyValue
     */
    public function getArray($keyValue = null)
    {
        return parent::getArray($keyValue);
    }

    /**
     * Ambil data child dari tipe yang dicari
     *
     * @param string|null $keyValue
     * @return TypeCollection
     * @throws \Exception
     * */
    public function children($keyValue = null)
    {
        if($this->items->count() == 0)
            throw new \Exception("Data tipe tidak ditemukan");

        if(is_null($keyValue))
            $keyValue = $this->keys->first();

        $data = $this->items->filter(function($data) use ($keyValue) {
            /* @var TypeColumn $data*/
            return $data->parent()->get($this->key) == $keyValue;
        });

        return new TypeCollection($data->toArray());
    }
}
