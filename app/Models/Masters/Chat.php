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

    protected $casts = [
        'createddate' => 'datetime:Y-m-d h:i:s'
    ];

    public function chatbp()
    {
        return $this->belongsTo(BusinessPartner::class, "chatbpid", "bpid");
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
