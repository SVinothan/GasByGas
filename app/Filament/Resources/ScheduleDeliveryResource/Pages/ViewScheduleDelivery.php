<?php

namespace App\Filament\Resources\ScheduleDeliveryResource\Pages;

use App\Filament\Resources\ScheduleDeliveryResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Models\Invoice;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Livewire;
use App\Livewire\ScheduleDelivery\ViewScheduleDeliveryStockTable;

class ViewScheduleDelivery extends Page
{
    use InteractsWithRecord;

    protected static string $resource = ScheduleDeliveryResource::class;

    protected static string $view = 'filament.resources.schedule-delivery-resource.pages.view-schedule-delivery';


    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $data=$record;
    }
   
    public function scheduleDeliveryInfolist(Infolist $infolist): Infolist
    {
        $record = $this->record;
        return $infolist
        ->record($this->record)
            ->schema([
                Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Scheduled Delivery')
                        ->schema([
                            Section::make('')
                            ->description('')
                            ->schema([
                                Grid::make([
                                    'sm'=>1,
                                    'md'=>4,
                                    'lg' => 4,
                                ])
                                ->schema([
                                    TextEntry::make('scheduleDeliveryProvince.name_en'),
                                    TextEntry::make('scheduleDeliveryDistrict.name_en'),
                                    TextEntry::make('scheduleDeliveryCity.name_en'),
                                    TextEntry::make('scheduleDeliveryOutlet.outlet_name'),
                                ]),
                                Grid::make([
                                    'sm'=>1,
                                    'md'=>3,
                                    'lg' => 3,
                                ])
                                ->schema([
                                    TextEntry::make('schedule_no'),
                                    TextEntry::make('date'),
                                    TextEntry::make('scheduled_date'),
                                    TextEntry::make('no_of_item'),
                                    TextEntry::make('no_of_qty'),
                                    TextEntry::make('amount'),
                                    TextEntry::make('scheduleDeliveryDispatchedUser.name')->hidden(fn($record):bool=> $record->dispatched_by == null ? true : false),
                                    TextEntry::make('scheduleDeliveryRecievedUser.name')->hidden(fn($record):bool=> $record->dispatched_by == null ? true : false),
                                    TextEntry::make('recieved_date')->hidden(fn($record):bool=> $record->dispatched_by == null ? true : false),
                                ]),
                            ]),
                        ]),
                    Tabs\Tab::make('Delivery Stocks')
                    ->schema([
                        Livewire::make(ViewScheduleDeliveryStockTable::class,['id'=>$this->record->id])
                    ]),
                  
                ])
            ]);
    }

}
