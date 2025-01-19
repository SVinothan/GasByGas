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

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Items', Item::count()),
            Stat::make('Stock Quantity', Stock::sum('qty')),
            Stat::make('Outlets', Outlet::count()),
            Stat::make('Scheduled Deliveries', ScheduleDelivery::whereNotIn('status',['Delivered','Canceled'])->count()),
            Stat::make('Customer Orders', CustomerOrder::whereNotIn('status',['Finished','Canceled'])->count()),
            Stat::make('Customer Invoices', CustomerInvoice::count())
                ->description('Paid : '.CustomerInvoice::where('status','Paid')->count() . ' Delivered : '.CustomerInvoice::where('status','Delivered')->count()),
        ];
    }
}
