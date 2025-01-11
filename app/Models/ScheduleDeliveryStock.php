<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDeliveryStock extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function scheduleDeliveryStockProvince()
    {
        return $this->belongsTo(Province::class,'province_id');
    }

    public function scheduleDeliveryStockDistrict()
    {
        return $this->belongsTo(District::class,'district_id');
    }

    public function scheduleDeliveryStockCity()
    {
        return $this->belongsTo(City::class,'city_id');
    }

    public function scheduleDeliveryStockOutlet()
    {
        return $this->belongsTo(Outlet::class,'outlet_id');
    }

    public function scheduleDeliveryStockItem()
    {
        return $this->belongsTo(Item::class,'item_id');
    }

    public function scheduleDeliveryDetail()
    {
        return $this->belongsTo(ScheduleDelivery::class,'schedule_delivery_id');
    }
}
