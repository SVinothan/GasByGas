<?php

namespace App\Filament\Resources\CustomerOrderItemResource\Pages;

use App\Filament\Resources\CustomerOrderItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerOrderItems extends ListRecords
{
    protected static string $resource = CustomerOrderItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
