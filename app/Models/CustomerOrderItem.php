<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customerOrderItemCity()
    {
        return $this->belongsTo(City::class,'city_id');
    }

    public function customerOrderItemOutlet()
    {
        return $this->belongsTo(Outlet::class,'outlet_id');
    }

    public function customerOrderItemCustomer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function customerOrderItemDetail()
    {
        return $this->belongsTo(Item::class,'item_id');
    }

    public function customerOrderDetail()
    {
        return $this->belongsTo(CustomerOrder::class,'customer_order_id');
    }
}
