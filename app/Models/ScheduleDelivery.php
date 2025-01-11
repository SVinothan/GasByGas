<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDelivery extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scheduleDeliveryStocks()
    {
        return $this->hasMany(ScheduleDeliveryStock::class,'schedule_delivery_id');
    }

    public function scheduleDeliveryProvince()
    {
        return $this->belongsTo(Province::class,'province_id');
    }

    public function scheduleDeliveryDistrict()
    {
        return $this->belongsTo(District::class,'district_id');
    }

    public function scheduleDeliveryCity()
    {
        return $this->belongsTo(City::class,'city_id');
    }

    public function scheduleDeliveryOutlet()
    {
        return $this->belongsTo(Outlet::class,'outlet_id');
    }
}
