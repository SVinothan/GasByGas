<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function stockProvince()
    {
        return $this->belongsTo(Province::class,'province_id');
    }

    public function stockDistrict()
    {
        return $this->belongsTo(District::class,'district_id');
    }

    public function stockCity()
    {
        return $this->belongsTo(City::class,'city_id');
    }

    public function stockOutlet()
    {
        return $this->belongsTo(Outlet::class,'outlet_id');
    }

    public function stockItem()
    {
        return $this->belongsTo(Item::class,'item_id');
    }
}
