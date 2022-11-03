<?php

namespace App\Models\Masters;

use DateTimeInterface;
use App\Models\DefaultModel;
use Tymon\JWTAuth\JWTAuth;

class Chat extends DefaultModel
{
    protected $table = "vtchat";
    protected $primaryKey = "chatid";

    protected $fillable = [
        "chatbpid",
        "chatmessage",
        "chatreftypeid",
        "chatrefid",
        "chatreadat",
        "chatreceiverid",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $casts = [
        'chatreftypeid' => 'integer',
    ];

    public function chatbp()
    {
        return $this->belongsTo(BusinessPartner::class, "chatbpid", "bpid");
    }

    public function chatreftype()
    {
        return $this->belongsTo(Types::class, "chatreftypeid", "typeid");
    }

    public function chatfile()
    {
        return $this->hasOne(Files::class, "refid", "chatid");
    }

    public function chatreceiver()
    {
        return $this->belongsTo(User::class, 'chatreceiverid', "userid");
    }

    public function createdbyuser()
    {
        return $this->belongsTo(User::class, 'createdby', "userid");
    }

    public function refprospect()
    {
        return $this->belongsTo(Prospect::class, 'chatrefid', 'prospectid');
    }

    public function refactivity()
    {
        return $this->belongsTo(DailyActivity::class, 'chatrefid', 'dayactid');
    }

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";
}
