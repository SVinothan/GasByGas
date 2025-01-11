<?php

namespace App\Filament\Resources\CustomerOrderResource\Pages;

use App\Filament\Resources\CustomerOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateCustomerOrder extends CreateRecord
{
    protected static string $resource = CustomerOrderResource::class;
    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // $stock = Stock::where('item_id',$data['item_id'])->where('outlet_id',$data['outlet_id'])->get();
        // if($data['qty'] > $stock->sum('qty'))
        // {
        //     $scheduledStock = ScheduleDeliveryStock::where('item_id',$data['item_id'])->where('outlet_id',$data['outlet_id'])->whereIn('status',['Scheduled','Confirmed'])->where('schedule_date','<=',Carbon::now()->addDays(14)->format('Y-m-d'))->get();
        //     $scheduledStock->sum('qty') >
        // }

        $data['user_id'] = auth()->user()->id;
        return $data;
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
            ->body('The Outlet has been created successfully.');
    }
}

