<?php

namespace App\Filament\Resources\ScheduleDeliveryResource\Pages;

use App\Filament\Resources\ScheduleDeliveryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\ScheduleDelivery;
use App\Models\ScheduleDeliveryStock;
use Illuminate\Support\Carbon;
use Filament\Notifications\Notification;

class CreateScheduleDelivery extends CreateRecord
{
    protected static string $resource = ScheduleDeliveryResource::class;
    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->user()->id;
        $data['schedule_no'] = 'GBG-'.Carbon::now()->format('Y').''.Carbon::now()->format('m').'-'.
                                sprintf("%03d" ,ScheduleDelivery::whereMonth('created_at',Carbon::now()->format('m'))->max('id') + 1);
        $data['status']='Scheduled';
        $data['date'] = Carbon::now()->format('Y-m-d');
        return $data;
    }

    protected function afterCreate()
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
            $stock->status = $data->status;
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

    protected function getCreatedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title('Succcess')
            ->body('The Delivery  has been scheduled successfully.');
    }
}
