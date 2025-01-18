<?php

namespace App\Filament\Resources\CustomerInvoiceItemResource\Pages;

use App\Filament\Resources\CustomerInvoiceItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerInvoiceItem extends EditRecord
{
    protected static string $resource = CustomerInvoiceItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
