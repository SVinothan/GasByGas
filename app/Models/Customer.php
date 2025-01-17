<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function customerProvince()
    {
        return $this->belongsTo(Province::class,'province_id');
    }

    public function customerDistrict()
    {
        return $this->belongsTo(District::class,'district_id');
    }

    public function customerCity()
    {
        return $this->belongsTo(City::class,'city_id');
    }

}
