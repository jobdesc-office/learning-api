<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class ProspectProduct extends Model
{
    protected $table = "trprospectproduct";
    protected $primaryKey = "prosproductid";

    protected $fillable = [
        "prosproductprospectid",
        "prosproductprice",
        "prosproductqty",
        "prosproducttax",
        "prosproductdiscount",
        "prosproductamount",
        "prosproducttaxtypeid",
        "createdby",
        "updatedby",
        'isactive',
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function prosproductprospectid()
    {
        return $this->belongsTo(Prospect::class, 'prosproductprospectid', 'prospectid');
    }

    public function prosproducttaxtypeid()
    {
        return $this->belongsTo(Types::class, 'prosproducttaxtypeid', 'typeid');
    }
}
