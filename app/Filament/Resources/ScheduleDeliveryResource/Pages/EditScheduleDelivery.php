<?php

namespace App\Filament\Resources\ScheduleDeliveryResource\Pages;

use App\Filament\Resources\ScheduleDeliveryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use App\Models\ScheduleDelivery;
use App\Models\ScheduleDeliveryStock;

class EditScheduleDelivery extends EditRecord
{
    protected static string $resource = ScheduleDeliveryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
            // Actions\ForceDeleteAction::make(),
            // Actions\RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = auth()->user()->id;
        return $data;
    }

    protected function afterSave()
    {
        $data = $this->record;
        $no_of_qty = 0;
        $amount = 0;
        foreach ($data->scheduleDeliveryStocks as $deliveryStock) 
        {
            $stock = ScheduleDeliveryStock::find($deliveryStock->id);
            $stock->province_id = $data->province_id;
            $stock->district_id = $data->district_id;
            $stock->city_id = $data->city_id;
            $stock->outlet_id = $data->outlet_id;
            $stock->scheduled_date = $data->scheduled_date;
            $stock->user_id = $data->user_id;
            $stock->total = $stock->qty * $stock->cost_price;
            $stock->update();

            $no_of_qty +=  $stock->qty;
            $amount +=  $stock->total;
        }

        $data->no_of_qty = $no_of_qty;
        $data->no_of_item = $data->scheduleDeliveryStocks->count();
        $data->amount = $amount;
        $data->update();
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title('Succcess')
            ->body('The Delivery Schedule has been updated successfully.');
    }
}
