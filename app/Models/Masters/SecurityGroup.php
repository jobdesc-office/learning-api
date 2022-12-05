<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class SecurityGroup extends DefaultModel
{
    protected $table = "stsecuritygroup";
    protected $primaryKey = "sgid";

    protected $fillable = [
        "sgcode",
        "sgname",
        "sgmasterid",
        "sgbpid",
        "createdby",
        "updatedby",
        'isactive',
    ];

    protected $alias = [
        "sgcode" => "Code",
        "sgname" => "Name",
        "sgmasterid" => "Master ID",
        "sgbpid" => "Business Partner ID",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function parent()
    {
        return $this->belongsTo(SecurityGroup::class, 'sgmasterid', 'sgid');
    }

    public function children()
    {
        return $this->hasMany(SecurityGroup::class, 'sgid', 'sgmasterid',);
    }

    public function businesspartner()
    {
        return $this->belongsTo(BusinessPartner::class, 'sgbpid', 'bpid');
    }

    public function usercreatedby()
    {
        return $this->belongsTo(User::class, "createdby", "userid");
    }

    public function userupdatedby()
    {
        return $this->belongsTo(User::class, "updatedby", "userid");
    }
}
