<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outlet extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function outletProvince()
    {
        return $this->belongsTo(Province::class,'province_id');
    }

    public function outletDistrict()
    {
        return $this->belongsTo(District::class,'district_id');
    }

    public function outletCity()
    {
        return $this->belongsTo(City::class,'city_id');
    }
}
