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
                                    TextEntry::make('customerOrderProvince.name_en'),
                                    TextEntry::make('customerOrderDistrict.name_en'),
                                    TextEntry::make('customerOrderCity.name_en'),
                                    TextEntry::make('customerOrderOutlet.outlet_name'),
                                ]),
                                Grid::make([
                                    'sm'=>1,
                                    'md'=>3,
                                    'lg' => 3,
                                ])
                                ->schema([
                                    TextEntry::make('customerOrderCustomer.full_name'),
                                    TextEntry::make('token_no'),
                                    TextEntry::make('invoice_date'),
                                    TextEntry::make('no_of_items'),
                                    TextEntry::make('no_of_qty'),
                                    TextEntry::make('status'),
                                    TextEntry::make('total'),
                                    TextEntry::make('paid_amount'),
                                    TextEntry::make('balance'),
                                ]),
                            ]),
                        ]),
                    Tabs\Tab::make('Delivery Stocks')
                    ->schema([
                        Livewire::make(ViewCustomerInvoiceItemTable::class,['id'=>$this->record->id])
                    ]),
                  
                ])
            ]);
    }
}
