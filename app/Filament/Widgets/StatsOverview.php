<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Item;
use App\Models\Stock;
use App\Models\Outlet;
use App\Models\ScheduleDelivery;
use App\Models\CustomerOrder;
use App\Models\CustomerInvoice;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        if(auth()->user()->getRoleNames()->first() == 'Customer')
        {
            return [
                Stat::make('Items', Item::count()),
                // Stat::make('Stock Quantity', Stock::where('city_id',auth()->user()->userCustomer->city_id)->sum('qty')),
                Stat::make('Outlets', Outlet::where('city_id',auth()->user()->userCustomer->city_id)->count()),
                Stat::make('Scheduled Deliveries', ScheduleDelivery::whereNotIn('status',['Delivered','Canceled'])->where('city_id',auth()->user()->userCustomer->city_id)->count()),
                Stat::make('Customer Orders', CustomerOrder::whereNotIn('status',['Finished','Canceled'])->where('customer_id',auth()->user()->customer_id)->count()),
                Stat::make('Customer Invoices', CustomerInvoice::where('customer_id',auth()->user()->customer_id)->count())
                    ->description('Paid : '.CustomerInvoice::where('status','Paid')->where('customer_id',auth()->user()->customer_id)->count() . ' Delivered : '.CustomerInvoice::where('status','Delivered')->where('customer_id',auth()->user()->customer_id)->count()),
            ];
        }
        else if(auth()->user()->getRoleNames()->first() == 'OutletManager')
        {
            $stockValue = Stock::where('outlet_id',auth()->user()->userEmployee->outlet_id)->select(DB::raw('sum(qty * cost_price) as stock_value'))->value('stock_value');
            return [
                Stat::make('Items', Item::count()),
                Stat::make('Stock Quantity', Stock::where('outlet_id',auth()->user()->userEmployee->outlet_id)->sum('qty')),
                Stat::make('Stock Value', number_format($stockValue, 2)),
                Stat::make('Scheduled Deliveries', ScheduleDelivery::whereNotIn('status',['Delivered','Canceled'])->where('outlet_id',auth()->user()->userEmployee->outlet_id)->count()),
                Stat::make('Customer Orders', CustomerOrder::whereNotIn('status',['Finished','Canceled'])->where('outlet_id',auth()->user()->userEmployee->outlet_id)->count()),
                Stat::make('Customer Invoices', CustomerInvoice::where('outlet_id',auth()->user()->userEmployee->outlet_id)->count())
                    ->description('Paid : '.CustomerInvoice::where('status','Paid')->where('outlet_id',auth()->user()->userEmployee->outlet_id)->count() . ' Delivered : '.CustomerInvoice::where('status','Delivered')->where('outlet_id',auth()->user()->userEmployee->outlet_id)->count()),
            ];
        }
        else
        {
            $stockValue = Stock::select(DB::raw('sum(qty * cost_price) as stock_value'))->value('stock_value');

            return [
                Stat::make('Items', Item::count()),
                Stat::make('Stock Quantity', Stock::sum('qty'))
                    ->description('Stock Value : ' . number_format($stockValue, 2)),
                Stat::make('Outlets', Outlet::count()),
                Stat::make('Scheduled Deliveries', ScheduleDelivery::whereNotIn('status',['Delivered','Canceled'])->count()),
                Stat::make('Customer Orders', CustomerOrder::whereNotIn('status',['Finished','Canceled'])->count()),
                Stat::make('Customer Invoices', CustomerInvoice::count())
                    ->description('Paid : '.CustomerInvoice::where('status','Paid')->count() . ' Delivered : '.CustomerInvoice::where('status','Delivered')->count()),
            ];
        }
    }
}
