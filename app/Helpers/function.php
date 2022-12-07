<?php

use App\Actions\FindTypeAction;
use App\Actions\FindBpTypeAction;
use App\Models\Masters\SecurityGroup;
use App\Models\Masters\UserDetail;
use Illuminate\Support\Collection;

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

function getSecurities($security)
{
    $securities = collect([]);
    if ($security instanceof Collection) {
        foreach ($security as $sc) {
            $securities->push(...getSecurities($sc));
        }
    } else {
        if ($security->children->isNotEmpty()) $securities->push(...getSecurities($security->children));
        $securities->push($security);
    }
    return $securities;
}

function kacungs($id = null)
{
    $security = null;
    if ($id != null) {
        $security = SecurityGroup::find($id);
    } else {
        $bpid = request()->header('bpid');
        $userid = auth()->id();
        $userdetail = UserDetail::where(['userid' => $userid, 'userdtbpid' => $bpid])->first();
        $security = $userdetail->securitygroup;
    }
    $groups = getSecurities($security->children);
    $kacungs = collect([]);
    foreach ($groups as $group) {
        $kacungs->push(...$group->users);
    }

    return $kacungs;
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
