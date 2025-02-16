<?php

namespace App\Filament\Exports;

use App\Models\CustomerInvoice;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class CustomerPaymentExporter extends Exporter
{
    protected static ?string $model = CustomerInvoice::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('customerInvoiceDistrict.name_en')->label('District'),
            ExportColumn::make('customerInvoiceCity.name_en')->label('City'),
            ExportColumn::make('customerInvoiceOutlet.outlet_name')->label('Outlet'),
            ExportColumn::make('customerInvoiceCustomer.full_name')->label('Customer'),
            ExportColumn::make('customerInvoiceCustomer.mobile_no')->label('Customer Mobile'),
            ExportColumn::make('customerInvoiceCustomer.nic_no')->label('Customer NIC')->state(fn () => '**********'),
            ExportColumn::make('token_no')->label('Token'),
            ExportColumn::make('total'),
            ExportColumn::make('paid_amount'),
            ExportColumn::make('balance'),
            ExportColumn::make('invoice_date'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your customer payment export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
