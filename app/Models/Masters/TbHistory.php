<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class TbHistory extends DefaultModel
{
    protected $table = "sttbhistory";
    protected $primaryKey = "tbhistoryid";
    protected static $history = false;

    protected $fillable = [
        "tbhistorytbname",
        "tbhistorytbfield",
        "tbhistoryasfield",
        "tbhistorycallfunc",
        "tbhistoryremarkformat",
        "createdby",
        "updatedby",
        'isactive',
    ];

    public function trhistories()
    {
        return $this->hasMany(TrHistory::class, 'historytbhistoryid', 'tbhistoryid');
    }

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";
}
