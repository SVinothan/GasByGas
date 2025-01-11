<?php

namespace App\Filament\Resources\ScheduleDeliveryStockResource\Pages;

use App\Filament\Resources\ScheduleDeliveryStockResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListScheduleDeliveryStocks extends ListRecords
{
    protected static string $resource = ScheduleDeliveryStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
