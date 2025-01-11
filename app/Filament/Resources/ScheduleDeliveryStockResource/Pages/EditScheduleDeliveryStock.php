<?php

namespace App\Filament\Resources\ScheduleDeliveryStockResource\Pages;

use App\Filament\Resources\ScheduleDeliveryStockResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditScheduleDeliveryStock extends EditRecord
{
    protected static string $resource = ScheduleDeliveryStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
