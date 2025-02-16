<?php

namespace App\Filament\Exports;

use App\Models\CustomerInvoiceItem;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class CustomerInvoiceItemExporter extends Exporter
{
    protected static ?string $model = CustomerInvoiceItem::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('customerInvoiceItemDistrict.name_en')->label('District'),
            ExportColumn::make('customerInvoiceItemCity.name_en')->label('City'),
            ExportColumn::make('customerInvoiceItemOutlet.outlet_name')->label('Outlet'),
            ExportColumn::make('customerInvoiceItemCustomer.full_name')->label('Customer'),
            ExportColumn::make('customerInvoiceDetail.token_no')->label('Token'),
            ExportColumn::make('customerInvoiceItemDetail.name')->label('Item Name'),
            ExportColumn::make('qty'),
            ExportColumn::make('amount'),
            ExportColumn::make('total'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your customer invoice item export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
