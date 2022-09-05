<?php

namespace App\Models\Masters;

use App\Models\DefaultModel;

class ProspectProduct extends DefaultModel
{
    protected $table = "trprospectproduct";
    protected $primaryKey = "prosproductid";

    protected $fillable = [
        "prosproductprospectid",
        "prosproductproductid",
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

    protected $alias = [
        "prosproductprospectid" => "Prospect Id",
        "prosproductproductid" => "Product Id",
        "prosproductprice" => "Price",
        "prosproductqty" => "Quantity",
        "prosproducttax" => "Tax",
        "prosproductdiscount" => "Discount",
        "prosproductamount" => "Amount",
        "prosproducttaxtypeid" => "Tax Type Id",
    ];

    const CREATED_AT = "createddate";
    const UPDATED_AT = "updateddate";

    public function prosproductprospect()
    {
        return $this->belongsTo(Prospect::class, 'prosproductprospectid', 'prospectid');
    }

    public function prosproductproduct()
    {
        return $this->belongsTo(Product::class, 'prosproductproductid', 'productid');
    }

    public function prosproducttaxtype()
    {
        return $this->belongsTo(Types::class, 'prosproducttaxtypeid', 'typeid');
    }

    public function prospectproductcreatedby()
    {
        return $this->belongsTo(User::class, "createdby", "userid");
    }

    public function prospectproductupdatedby()
    {
        return $this->belongsTo(User::class, "updatedby", "userid");
    }
}
