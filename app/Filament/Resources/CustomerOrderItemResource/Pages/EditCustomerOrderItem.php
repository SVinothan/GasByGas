<?php

namespace App\Filament\Resources\CustomerOrderItemResource\Pages;

use App\Filament\Resources\CustomerOrderItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerOrderItem extends EditRecord
{
    protected static string $resource = CustomerOrderItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
