<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function cityProvince()
    {
        return $this->belongsTo(Province::class,'province_id');
    }

    public function cityDistrict()
    {
        return $this->belongsTo(District::class,'district_id');
    }
}
