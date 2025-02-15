<?php

namespace App\Filament\Resources\CustomerInvoiceResource\Pages;

use App\Filament\Resources\CustomerInvoiceResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Models\CustomerInvoice;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Livewire;
use App\Livewire\CustomerInvoice\ViewCustomerInvoiceItemTable;

class ViewCustomerInvoice extends Page
{
    use InteractsWithRecord;

    protected static string $resource = CustomerInvoiceResource::class;

    protected static string $view = 'filament.resources.customer-invoice-resource.pages.view-customer-invoice';
    
    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $data=$record;
    }
   
    public function customerInvoiceInfolist(Infolist $infolist): Infolist
    {
        $record = $this->record;
        return $infolist
        ->record($this->record)
            ->schema([
                Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Customer Invoice')
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
                                    TextEntry::make('customerInvoiceProvince.name_en')->label('Province')
                                        ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' || auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),
                                    TextEntry::make('customerInvoiceDistrict.name_en')->label('District')
                                        ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' || auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),
                                    TextEntry::make('customerInvoiceCity.name_en')->label('City')
                                        ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' || auth()->user()->getRoleNames()->first() == 'Customer'? true : false),
                                    TextEntry::make('customerInvoiceOutlet.outlet_name')->label('Outlet')
                                        ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' ? true : false),
                                ]),
                                Grid::make([
                                    'sm'=>1,
                                    'md'=>3,
                                    'lg' => 3,
                                ])
                                ->schema([
                                    TextEntry::make('customerInvoiceCustomer.full_name')->label('Customer')
                                        ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),
                                    TextEntry::make('customerInvoiceCustomer.mobile_no')->label('Customer Mobile')
                                        ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),
                                    TextEntry::make('token_no')->label('Token Number'),
                                    TextEntry::make('invoice_date'),
                                    TextEntry::make('no_of_items')->label('Number of Item'),
                                    TextEntry::make('qty'),
                                    TextEntry::make('status'),
                                    TextEntry::make('total'),
                                    TextEntry::make('paid_amount'),
                                    TextEntry::make('balance'),
                                ]),
                            ]),
                        ]),
                    Tabs\Tab::make('Invoice Items')
                    ->schema([
                        Livewire::make(ViewCustomerInvoiceItemTable::class,['id'=>$this->record->id])
                    ]),
                  
                ])
            ]);
    }
}
