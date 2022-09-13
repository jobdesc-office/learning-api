<?php

use App\Actions\FindTypeAction;
use App\Actions\FindBpTypeAction;

function find_type($key = 'typecd', $keys = [], $items = [])
{
    return (new FindTypeAction());
}

function find_bptype($key = 'typecd', $keys = [], $items = [])
{
    return (new FindBpTypeAction());
}

function pgsql()
{
    return Schema::connection('pgsql');
}

function pgsql2()
{
    return Schema::connection('pgsql2');
}

class TempFile
{
    /**
     * @var resource
     */
    public $stream;

    /**
     * @param string $data
     */
    public function __construct($data)
    {
        $this->stream = tmpfile();
        fwrite($this->stream, $data);
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return stream_get_meta_data($this->stream)['uri'];
    }

    public function close()
    {
        fclose($this->stream);
    }
}
