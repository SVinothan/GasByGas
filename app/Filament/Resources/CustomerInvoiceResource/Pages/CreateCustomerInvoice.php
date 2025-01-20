<?php

namespace App\Filament\Resources\CustomerInvoiceResource\Pages;

use App\Filament\Resources\CustomerInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerOrder;
use App\Models\CustomerInvoice;
use App\Models\CustomerInvoiceItem;

class CreateCustomerInvoice extends CreateRecord
{
    protected static string $resource = CustomerInvoiceResource::class;
    protected static bool $canCreateAnother = false;

    protected function handleRecordCreation(array $data): Model
    {
        $order = CustomerOrder::find($data['customer_order_id']);
        if($order->schedule_delivery_id != null)
        {
            $stock = Stock::where('schedule_delivery_id',$order->schedule_delivery_id)->count();
            if($stock == 0)
            {
                $delivery = ScheduleDelivery::find($order->schedule_delivery_id);
                if($delivery->status == 'Scheduled')
                {
                    $fail("The ordered stock is not delivered yet. Please come again after confirmation mail recieved.");
                }
            }
        }

       
        $invoice = new CustomerInvoice;
        $invoice->province_id = $order->province_id;
        $invoice->district_id = $order->district_id;
        $invoice->city_id = $order->city_id;
        $invoice->outlet_id = $order->outlet_id;
        $invoice->customer_id = $order->customer_id;
        $invoice->customer_order_id = $order->id;
        $invoice->token_no = $order->token_no;
        $invoice->no_of_items = $order->no_of_items;
        $invoice->qty = $order->qty;
        $invoice->order_date = $order->order_date;
        $invoice->pickup_date = $order->pickup_date;
        $invoice->invoice_date = Carbon::now()->format('Y-m-d');
        $invoice->total = $order->total;
        $invoice->paid_amount = $data['amount'];
        $invoice->balance = $data['balance'];
        $invoice->status = 'Paid';
        $invoice->user_id = auth()->user()->id;
        $invoice->save();

        $invoiceItem = new CustomerInvoiceItem;
        $invoiceItem->province_id = $order->province_id;
        $invoiceItem->district_id = $order->district_id;
        $invoiceItem->city_id = $order->city_id;
        $invoiceItem->outlet_id = $order->outlet_id;
        $invoiceItem->customer_id = $order->customer_id;
        $invoiceItem->customer_order_id = $order->id;
        $invoiceItem->customer_invoice_id = $invoice->id;
        $invoiceItem->item_id = $order->customerOrderItem->item_id;
        $invoiceItem->stock_id = $order->customerOrderItem->stock_id;
        $invoiceItem->schedule_delivery_id = $order->customerOrderItem->schedule_delivery_id;
        $invoiceItem->qty = $order->customerOrderItem->qty;
        $invoiceItem->sales_price = $order->customerOrderItem->sales_price;
        $invoiceItem->total = $order->customerOrderItem->sales_price * $order->customerOrderItem->qty;
        $invoiceItem->user_id = auth()->user()->id;
        $invoiceItem->save();

        $order->status = 'Finished';
        $order->update();

        CstomerOrderItem::where('customer_order_id',$order->id)->update(['status'=>'Finished']);
        
        return $invoice;
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title('Succcess')
            ->body('The Invoice has been created successfully.');
    }
}
