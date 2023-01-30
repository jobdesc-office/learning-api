<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class TrHistory extends DefaultModel
{
    protected $table = "trhistory";
    protected $primaryKey = "historyid";
    protected static $history = false;

    protected $fillable = [
        "historytbhistoryid",
        "historyrefid",
        "historyremark",
        "historyoldvalue",
        "historynewvalue",
        "historybpid",
        "historysource",
        "createdby",
        'isactive',
    ];


    public function historyrefprospectfile()
    {
        return $this->belongsTo(Files::class, 'historyrefid', 'fileid');
    }

    public function historyrefprospectcustomfield()
    {
        return $this->belongsTo(ProspectCustomField::class, 'historyrefid', 'prospectcfid');
    }

    public function historyrefprospectactivity()
    {
        return $this->belongsTo(DailyActivity::class, 'historyrefid', 'dayactid');
    }

    public function historyrefprospectassign()
    {
        return $this->belongsTo(ProspectAssign::class, 'historyrefid', 'prospectassignid');
    }

    public function historyrefprospectproduct()
    {
        return $this->belongsTo(ProspectProduct::class, 'historyrefid', 'prosproductid');
    }

    public function historytbhistory()
    {
        return $this->belongsTo(TbHistory::class, 'historytbhistoryid', 'tbhistoryid');
    }

    public function historyuser()
    {
        return $this->belongsTo(User::class, 'createdby', 'userid');
    }

    const CREATED_AT = "createddate";

    public $timestamps = false;
}
