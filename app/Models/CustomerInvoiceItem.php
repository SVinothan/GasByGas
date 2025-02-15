<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInvoiceItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customerInvoiceItemCity()
    {
        return $this->belongsTo(City::class,'city_id');
    }

    public function customerInvoiceItemOutlet()
    {
        return $this->belongsTo(Outlet::class,'outlet_id');
    }

    public function customerInvoiceItemCustomer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function customerInvoiceItemDetail()
    {
        return $this->belongsTo(Item::class,'item_id');
    }

    public function customerInvoiceDetail()
    {
        return $this->belongsTo(CustomerInvoice::class,'customer_invoice_id');
    }
}
