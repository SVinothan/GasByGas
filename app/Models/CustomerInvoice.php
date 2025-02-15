<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInvoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customerInvoiceCity()
    {
        return $this->belongsTo(City::class,'city_id');
    }

    public function customerInvoiceOutlet()
    {
        return $this->belongsTo(Outlet::class,'outlet_id');
    }

    public function customerInvoiceCustomer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function customerInvoiceProvince()
    {
        return $this->belongsTo(Province::class,'province_id');
    }

    public function customerInvoiceDistrict()
    {
        return $this->belongsTo(District::class,'district_id');
    }
}
