<?php

namespace App\Filament\Exports;

use App\Models\CustomerOrder;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class CustomerOrderExporter extends Exporter
{
    protected static ?string $model = CustomerOrder::class;

    public static function getColumns(): array
    {
        return [
            
            ExportColumn::make('customerOrderDistrict.name_en')->label('District'),
            ExportColumn::make('customerOrderCity.name_en')->label('City'),
            ExportColumn::make('customerOrderOutlet.outlet_name')->label('Outlet'),
            ExportColumn::make('customerOrderCustomer.full_name')->label('Customer'),
            ExportColumn::make('customerOrderCustomer.mobile_no')->label('Customer Mobile'),
            ExportColumn::make('customerOrderCustomer.nic_no')->label('Customer NIC')->state(fn () => '**********'),
            ExportColumn::make('token_no')->label('Token'),
            ExportColumn::make('no_of_items')->label('Number of Items'),
            ExportColumn::make('qty'),
            ExportColumn::make('amount')->label('Total'),
            ExportColumn::make('status'),
            ExportColumn::make('order_date'),
            ExportColumn::make('pickup_date'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your customer order export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
