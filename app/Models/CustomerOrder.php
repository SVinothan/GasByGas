<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customerOrderItems()
    {
        return $this->hasMany(CustomerOrderItem::class,'customer_order_id');
    }

    public function customerOrderCity()
    {
        return $this->belongsTo(City::class,'city_id');
    }

    public function customerOrderOutlet()
    {
        return $this->belongsTo(Outlet::class,'outlet_id');
    }

    public function customerOrderCustomer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
