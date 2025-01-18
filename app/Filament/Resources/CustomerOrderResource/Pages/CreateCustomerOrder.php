<?php

namespace App\Filament\Resources\CustomerOrderResource\Pages;

use App\Filament\Resources\CustomerOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class CreateCustomerOrder extends CreateRecord
{
    protected static string $resource = CustomerOrderResource::class;
    protected static bool $canCreateAnother = false;

    protected function handleRecordCreation(array $data): Model
    {
        #check customer limit
        $qty = 0;
        foreach ($data['Items'] as $item)
        {
            $qty += $item['qty'];
        }
        if($qty > auth()->user()->userCustomer->cylinder_limit)
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
        foreach ($data['Items'] as $item)
        {
            $stock = Stock::where('item_id',$item['item_id'])->where('outlet_id',$data['outlet_id'])->sum('qty');
            $stockOrderedQty = CustomerOrderItem::where('item_id',$item['item_id'])->where('outlet_id',$data['outlet_id'])->where('schedule_delivery_id',null)->whereNot('status','Finished')->sum('qty');

            if($item['qty'] + $stockOrderedQty > $stock)
            {
                $scheduledStock = ScheduleDeliveryStock::where('item_id',$item['item_id'])->where('outlet_id',$data['outlet_id'])->whereIn('status',['Scheduled','Confirmed'])->where('scheduled_date','<',Carbon::now()->addDays(14)->format('Y-m-d'))->orderBy('scheduled_date','asc')->get();
                
                if($scheduledStock->count() > 0)
                {
                    foreach ($scheduledStock as $schedule) 
                    {
                        $scheduleOrderedQty = CustomerOrderItem::where('item_id',$item['item_id'])->where('outlet_id',$data['outlet_id'])->where('schedule_delivery_id',$schedule->schedule_delivery_id)->sum('qty');
                        if($scheduleOrderedQty + $item['qty'] <= $schedule->qty)
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
        }

        #after validaion save function

        $order = new CustomerOrder;
        $outlet = Outlet::find($data['outlet_id']);
        $order->province_id = $outlet->province_id;
        $order->district_id = $outlet->district_id;
        $order->city_id = $outlet->city_id;
        $order->outlet_id = $data['outlet_id'];
        $order->customer_id = auth()->user()->customer_id;
        $order->qty = $qty;
        $order->status = 'Order Pending';
        $order->order_date = Carbon::now()->format('Y-m-d');
        $order->is_recieved_empty = '0';
        $order->user_id = auth()->user()->id;
        $order->token_no = 'GBG-'.Carbon::now()->format('Ym').'-'.sprintf("%04d",CustomerOrder::whereYear('order_date',Carbon::now()->format('Y')->count()));
        $order->save();

        foreach ($data['Items'] as $item)
        {
            $orderItem = new CustomerOrderItem;
            $orderItem->customer_order_id = $order->id;
            $orderItem->province_id = $order->province_id;
            $orderItem->district_id = $order->district_id;
            $orderItem->city_id = $order->city_id;
            $orderItem->outlet_id = $order->outlet_id;
            $orderItem->customer_id = auth()->user()->customer_id;
            $orderItem->order_date = Carbon::now()->format('Y-m-d');
            $orderItem->item_id = $item['item_id'];

            $stock = Stock::where('item_id',$item['item_id'])->where('outlet_id',$data['outlet_id'])->sum('qty');
            $stockOrderedQty = CustomerOrderItem::where('item_id',$item['item_id'])->where('outlet_id',$data['outlet_id'])->where('schedule_delivery_id',null)->whereNot('status','Finished')->sum('qty');

            if($item['qty'] + $stockOrderedQty > $stock)
            {
                $scheduledStock = ScheduleDeliveryStock::where('item_id',$item['item_id'])->where('outlet_id',$data['outlet_id'])->whereIn('status',['Scheduled','Confirmed'])->where('scheduled_date','<',Carbon::now()->addDays(14)->format('Y-m-d'))->orderBy('scheduled_date','asc')->get();
                
                foreach ($scheduledStock as $schedule) 
                {
                    $scheduleOrderedQty = CustomerOrderItem::where('item_id',$item['item_id'])->where('outlet_id',$data['outlet_id'])->where('schedule_delivery_id',$schedule->schedule_delivery_id)->sum('qty');
                    if($scheduleOrderedQty + $item['qty'] <= $schedule->qty)
                    {
                        $orderItem->qty = $item['qty'];
                        $orderItem->schedule_delivery_id = $schedule->schedule_delivery_id;
                        $orderItem->sales_price = $schedule->sales_price;
                        $orderItem->total = $schedule->sales_price * $item['qty'];
                        break;
                    }
                }
            }
            else
            {
                $stocks = Stock::where('item_id',$item['item_id'])->where('outlet_id',$data['outlet_id'])->orderBy('id','asc')->get();
                foreach ($stocks as $stock) 
                {
                    $orderedStock = CustomerOrderItem::where('item_id',$item['item_id'])->where('outlet_id',$data['outlet_id'])->where('stock_id',$stock->id)->sum('qty');
                    if($orderedStock + $item['qty'] <= $stock->qty)
                    {
                        $orderItem->qty = $item['qty'];
                        $orderItem->stock_id = $stock->id;
                        $orderItem->sales_price = $stock->sales_price;
                        $orderItem->total = $stock->sales_price * $item['qty'];
                        break;
                    }
                    else
                    {
                        $orderItem->qty =$stock->qty - $orderedStock;
                        $orderItem->stock_id = $stock->id;
                        $orderItem->sales_price = $stock->sales_price;
                        $orderItem->total = $stock->sales_price * ($stock->qty - $orderedStock);
                        
                        $item['qty'] =  $item['qty'] - $orderItem->qty;
                    }
                }
            }
            $orderItem->status = 'Order Pending';
            $orderItem->user_id = auth()->user()->id;
            $orderItem->save();
           
        }

        $order->update(['no_of_items'=>CustomerOrderItem::where('customer_order_id',$order->id)->count()]);
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

