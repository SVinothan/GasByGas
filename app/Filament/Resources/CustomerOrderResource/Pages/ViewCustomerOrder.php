<?php

namespace App\Filament\Resources\CustomerOrderResource\Pages;

use App\Filament\Resources\CustomerOrderResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Models\CustomerOrder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Livewire;
use App\Livewire\CustomerOrder\ViewCustomerOrderItemTable;

class ViewCustomerOrder extends Page
{
    use InteractsWithRecord;

    protected static string $resource = CustomerOrderResource::class;

    protected static string $view = 'filament.resources.customer-order-resource.pages.view-customer-order';

    
    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $data=$record;
    }
   
    public function customerOrderInfolist(Infolist $infolist): Infolist
    {
        $record = $this->record;
        return $infolist
        ->record($this->record)
            ->schema([
                Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Order Details')
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
                                    TextEntry::make('customerOrderProvince.name_en')->label('Province')
                                        ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' || auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),
                    
                                    TextEntry::make('customerOrderDistrict.name_en')->label('District')
                                        ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' || auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),

                                    TextEntry::make('customerOrderCity.name_en')->label('City')
                                        ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' || auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),

                                    TextEntry::make('customerOrderOutlet.outlet_name')->label('Outlet')
                                        ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' ? true : false),

                                ]),
                                Grid::make([
                                    'sm'=>1,
                                    'md'=>3,
                                    'lg' => 3,
                                ])
                                ->schema([
                                    TextEntry::make('customerOrderCustomer.full_name')->label('Customer')
                                        ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),
                                    TextEntry::make('customerOrderCustomer.mobile_no')->label('Customer Mobile')
                                        ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),
                                    TextEntry::make('token_no')->label('Token Number'),
                                    TextEntry::make('order_date'),
                                    TextEntry::make('pickup_date'),
                                    TextEntry::make('no_of_items')->label('Number of Items'),
                                    TextEntry::make('qty')->label('Number of Quantity'),
                                    TextEntry::make('status'),

                                ]),
                            ]),
                        ]),
                    Tabs\Tab::make('Order Items')
                    ->schema([
                        Livewire::make(ViewCustomerOrderItemTable::class,['id'=>$this->record->id])
                    ]),
                  
                ])
            ]);
    }
}
