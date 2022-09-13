<?php

namespace App\Collections\BpTypes;

use App\Collections\CollectionFinder;
use App\Models\Masters\Stbptype;
use Illuminate\Support\Facades\Log;

class BpTypeFinder extends CollectionFinder
{

    public function __construct($key, $keys, $items)
    {
        $this->model = new Stbptype();

        parent::__construct($key, $keys, collect($items)->map(function ($data) {
            return new BpTypeColumn($data);
        }));
    }

    /**
     * @return BpTypeColumn[]
     * */
    public function all()
    {
        return parent::all();
    }

    /**
     * @param string|null $keyValue
     * @param callable|null $callback
     * @return BpTypeColumn
     *
     * @throws \Exception
     */
    public function get($keyValue = null, $callback = null)
    {
        return parent::get($keyValue, $callback);
    }

    /**
     * @return BpTypeColumn[]
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
     * @return BpTypeCollection
     * @throws \Exception
     * */
    public function children($keyValue = null)
    {
        if ($this->items->count() == 0)
            throw new \Exception("Data tipe tidak ditemukan");

        if (is_null($keyValue))
            $keyValue = $this->keys->first();

        $data = $this->items->filter(function ($data) use ($keyValue) {
            /* @var BpTypeColumn $data*/
            return $data->parent()->get($this->key) == $keyValue;
        });
        return new BpTypeCollection($data->toArray());
    }
}
