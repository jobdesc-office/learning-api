<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\JWTAuth;

class Chat extends Model
{
    protected $table = "vtchat";
    protected $primaryKey = "chatid";

    protected $fillable = [
        "chatbpid",
        "chatmessage",
        "chatrefname",
        "chatrefid",
        "chatfile",
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

    public function chatreceiver()
    {
        return $this->belongsTo(User::class, 'chatreceiverid', "userid");
    }

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";
}
