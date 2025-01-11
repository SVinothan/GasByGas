<?php

namespace App\Filament\Resources\ScheduleDeliveryResource\Pages;

use App\Filament\Resources\ScheduleDeliveryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListScheduleDeliveries extends ListRecords
{
    protected static string $resource = ScheduleDeliveryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create New')->toolTip('Create New Schedule Delivery'),
        ];
    }
}
