<?php

namespace App\Filament\Exports;

use App\Models\CustomerOrderItem;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class CustomerOrderItemExporter extends Exporter
{
    protected static ?string $model = CustomerOrderItem::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('customerOrderItemDistrict.name_en')->label('District'),
            ExportColumn::make('customerOrderItemCity.name_en')->label('City'),
            ExportColumn::make('customerOrderItemOutlet.outlet_name')->label('Outlet'),
            ExportColumn::make('customerOrderItemCustomer.full_name')->label('Customer'),
            ExportColumn::make('order_date'),
            ExportColumn::make('customerOrderDetail.token_no')->label('Token'),
            ExportColumn::make('customerOrderItemDetail.name')->label('Item'),
            ExportColumn::make('qty'),
            ExportColumn::make('sales_price'),
            ExportColumn::make('total'),
            ExportColumn::make('status'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your customer order item export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
