<?php

use App\Actions\FindTypeAction;

function find_type($key = 'typecd', $keys = [], $items = [])
{
    return (new FindTypeAction());
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
