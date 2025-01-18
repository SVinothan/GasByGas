<?php

namespace App\Filament\Resources\CustomerInvoiceItemResource\Pages;

use App\Filament\Resources\CustomerInvoiceItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerInvoiceItems extends ListRecords
{
    protected static string $resource = CustomerInvoiceItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
