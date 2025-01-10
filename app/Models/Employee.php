<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function employeeProvince()
    {
        return $this->belongsTo(Province::class,'province_id');
    }

    public function employeeDistrict()
    {
        return $this->belongsTo(District::class,'district_id');
    }

    public function employeeCity()
    {
        return $this->belongsTo(City::class,'city_id');
    }

    public function employeeOutlet()
    {
        return $this->belongsTo(Outlet::class,'outlet_id');
    }

    public function employeeRole()
    {
        return $this->belongsTo(Role::class,'role_id');
    }

}
