<?php

namespace App\Filament\Resources\CustomerOrderResource\Pages;

use App\Filament\Resources\CustomerOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerOrder;
use App\Models\CustomerOrderItem;
use App\Models\ScheduleDeliveryStock;
use App\Models\Item;
use App\Models\Outlet;
use App\Models\Stock;
use Illuminate\Support\Carbon;

class CreateCustomerOrder extends CreateRecord
{
    protected static string $resource = CustomerOrderResource::class;
    protected static bool $canCreateAnother = false;

    protected function handleRecordCreation(array $data): Model
    {
        #check customer limit
        if($data['qty'] > auth()->user()->userCustomer->cylinder_limit)
        {
            Notification::make()
                ->warning()
                ->title('Warning!!')
                ->body('The ordered quantity is exceeding your limit. Please check.')
                ->send();
            $this->halt();
        }

        #check stock is available or not
        $schedule_delivery_id = null;

        $stock = Stock::where('item_id',$data['item_id'])->where('outlet_id',$data['outlet_id'])->sum('qty');
        $stockOrderedQty = CustomerOrderItem::where('item_id',$data['item_id'])->where('outlet_id',$data['outlet_id'])->where('schedule_delivery_id',null)->where('status','Order Pending')->sum('qty');

        if($data['qty'] + $stockOrderedQty > $stock)
        {
            $scheduledStock = ScheduleDeliveryStock::where('item_id',$data['item_id'])->where('outlet_id',$data['outlet_id'])->whereIn('status',['Scheduled','Confirmed'])->where('scheduled_date','<',Carbon::now()->addDays(14)->format('Y-m-d'))->orderBy('scheduled_date','asc')->get();
            
            if($scheduledStock->count() > 0)
            {
                foreach ($scheduledStock as $schedule) 
                {
                    $scheduleOrderedQty = CustomerOrderItem::where('item_id',$data['item_id'])->where('outlet_id',$data['outlet_id'])->where('schedule_delivery_id',$schedule->schedule_delivery_id)->sum('qty');
                    if($scheduleOrderedQty + $data['qty'] <= $schedule->qty)
                    {
                        $schedule_delivery_id = $schedule->schedule_delivery_id;
                        break;
                    }
                }
                if($schedule_delivery_id == null)
                {
                    Notification::make()
                        ->warning()
                        ->title('Warning!!')
                        ->body('There are no stock availabe. Try again later Or contact outlet manager.')
                        ->send();
                    return $stock;
                }
            }
            else
            {
                Notification::make()
                    ->warning()
                    ->title('Warning!!')
                    ->body('There are no stock availabe. Try again later Or contact outlet manager.')
                    ->send();
                return $stock;
            }
        }

        #after validaion save function

        $order = new CustomerOrder;
        $outlet = Outlet::find($data['outlet_id']);
        $order->province_id = $outlet->province_id;
        $order->district_id = $outlet->district_id;
        $order->city_id = $outlet->city_id;
        $order->outlet_id = $data['outlet_id'];
        $order->customer_id = auth()->user()->customer_id;
        $order->qty = $data['qty'];
        $order->status = 'Order Pending';
        $order->order_date = Carbon::now()->format('Y-m-d');
        $order->is_recieved_empty = '0';
        $order->user_id = auth()->user()->id;
        $order->token_no = 'GBG-'.Carbon::now()->format('Ym').'-'.sprintf("%04d",CustomerOrder::whereYear('order_date',Carbon::now()->format('Y'))->count() + 1);
        $order->save();

       
            $orderItem = new CustomerOrderItem;
            $orderItem->customer_order_id = $order->id;
            $orderItem->province_id = $order->province_id;
            $orderItem->district_id = $order->district_id;
            $orderItem->city_id = $order->city_id;
            $orderItem->outlet_id = $order->outlet_id;
            $orderItem->customer_id = auth()->user()->customer_id;
            $orderItem->order_date = Carbon::now()->format('Y-m-d');
            $orderItem->item_id = $data['item_id'];

            $stock = Stock::where('item_id',$data['item_id'])->where('outlet_id',$data['outlet_id'])->sum('qty');
            $stockOrderedQty = CustomerOrderItem::where('item_id',$data['item_id'])->where('outlet_id',$data['outlet_id'])->where('schedule_delivery_id',null)->whereNot('status','Finished')->sum('qty');

            if($data['qty'] + $stockOrderedQty > $stock)
            {
                $scheduledStock = ScheduleDeliveryStock::where('item_id',$data['item_id'])->where('outlet_id',$data['outlet_id'])->whereIn('status',['Scheduled','Confirmed'])->where('scheduled_date','<',Carbon::now()->addDays(14)->format('Y-m-d'))->orderBy('scheduled_date','asc')->get();
                
                foreach ($scheduledStock as $schedule) 
                {
                    $scheduleOrderedQty = CustomerOrderItem::where('item_id',$data['item_id'])->where('outlet_id',$data['outlet_id'])->where('schedule_delivery_id',$schedule->schedule_delivery_id)->sum('qty');
                    if($scheduleOrderedQty + $data['qty'] <= $schedule->qty)
                    {
                        $orderItem->qty = $data['qty'];
                        $orderItem->schedule_delivery_id = $schedule->schedule_delivery_id;
                        $orderItem->sales_price = $schedule->sales_price;
                        $orderItem->total = $schedule->sales_price * $data['qty'];
                        $order->pickup_date = Carbon::parse($schedule->scheduled_date)->addDays(1)->format('Y-m-d');
                        break;
                    }
                }
            }
            else
            {
                $stocks = Stock::where('item_id',$data['item_id'])->where('outlet_id',$data['outlet_id'])->orderBy('id','asc')->get();
                foreach ($stocks as $stock) 
                {
                    $orderedStock = CustomerOrderItem::where('item_id',$data['item_id'])->where('outlet_id',$data['outlet_id'])->where('stock_id',$stock->id)->sum('qty');
                    if($orderedStock + $data['qty'] <= $stock->qty)
                    {
                        $orderItem->qty = $data['qty'];
                        $orderItem->stock_id = $stock->id;
                        $orderItem->sales_price = $stock->sales_price;
                        $orderItem->total = $stock->sales_price * $data['qty'];
                        $order->pickup_date = Carbon::now()->addDays(1)->format('Y-m-d');
                        break;
                    }
                    else
                    {
                        $orderItem->qty =$stock->qty - $orderedStock;
                        $orderItem->stock_id = $stock->id;
                        $orderItem->sales_price = $stock->sales_price;
                        $orderItem->total = $stock->sales_price * ($stock->qty - $orderedStock);
                        $order->pickup_date = Carbon::now()->addDays(1)->format('Y-m-d');
                        $data['qty'] =  $data['qty'] - $orderItem->qty;
                    }
                }
            }
            $orderItem->status = 'Order Pending';
            $orderItem->user_id = auth()->user()->id;
            $orderItem->save();
           

        $order->no_of_items=CustomerOrderItem::where('customer_order_id',$order->id)->count();
        $order->amount = $orderItem->total;
        $order->update();
        return $order;
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
            ->body('The Outlet has been created successfully.');
    }
}

