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
        "chatrefname",
        "chatrefid",
        "chatreadat",
        "chatreceiverid",
        "createdby",
        "updatedby",
        'isactive',
    ];

    public function chatbp()
    {
        return $this->belongsTo(BusinessPartner::class, "chatbpid", "bpid");
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

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";
}
