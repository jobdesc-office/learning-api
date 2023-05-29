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

function getParents($security)
{
    $securities = collect([$security]);
    if ($security->parent != null) $securities->push(...getParents($security->parent));
    return $securities;
}

function kacungs($id = null)
{
    $security = null;
    if ($id != null) {
        $security = SecurityGroup::find($id);
    } else {
        $security = mySecurityGroup();
    }
    if ($security == null) return collect([]);
    $groups = getSecurities($security->children);
    $kacungs = collect([]);
    foreach ($groups as $group) {
        $kacungs->push(...$group->users);
    }

    return $kacungs;
}

function parents($id = null)
{
    $security = null;
    if ($id != null) {
        $security = SecurityGroup::find($id);
    } else {
        $security = mySecurityGroup();
    }
    if ($security == null) return collect([]);
    return getParents($security);
}

function mySecurityGroup()
{
    $bpid = request()->header('bpid');
    $userid = auth()->id();
    $userdetail = UserDetail::where(['userid' => $userid, 'userdtbpid' => $bpid])->first();
    return $userdetail->securitygroup;
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

function distance($lat1, $lon1, $lat2, $lon2, $unit) {
    if (($lat1 == $lat2) && ($lon1 == $lon2)) {
        return 0;
    }
    else {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}
