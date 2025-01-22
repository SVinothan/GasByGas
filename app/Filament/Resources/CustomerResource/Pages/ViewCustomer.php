<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Models\Customer;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Livewire;
use App\Livewire\Customer\ViewOrderTable;
use App\Livewire\Customer\ViewOrderItemTable;
use App\Livewire\Customer\ViewInvoiceTable;
use App\Livewire\Customer\ViewPaymentTable;

class ViewCustomer extends Page
{
    use InteractsWithRecord;

    protected static string $resource = CustomerResource::class;

    protected static string $view = 'filament.resources.customer-resource.pages.view-customer';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
   
    public function customerInfolist(Infolist $infolist): Infolist
    {
        $record = $this->record;
        return $infolist
        ->record($this->record)
            ->schema([
                Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Details')
                        ->schema([
                            Section::make('')
                            ->description('')
                            ->schema([
                                Grid::make([
                                    'sm'=>1,
                                    'md'=>3,
                                    'lg' => 3,
                                ])
                                ->schema([
                                    TextEntry::make('customerProvince.name_en'),
                                    TextEntry::make('customerDistrict.name_en'),
                                    TextEntry::make('customerCity.name_en'),
                                    TextEntry::make('full_name'),
                                    TextEntry::make('email'),
                                    TextEntry::make('nic_no'),
                                    TextEntry::make('mobile_no'),
                                    TextEntry::make('address'),
                                    TextEntry::make('type'),
                                    TextEntry::make('status'),
                                    TextEntry::make('cylinder_limit'),
                                    TextEntry::make('bussiness_name')->hidden(fn($record):bool=>$record->type == 'Individual' ? true : false),
                                    ImageEntry::make('bussiness_reg_document')->hidden(fn($record):bool=>$record->type == 'Individual' ? true : false)
                                        ->columnSpanFull(),

                                ]),
                            ]),
                        ]),
                    Tabs\Tab::make('Orders')
                    ->schema([
                        Livewire::make(ViewOrderTable::class,['id'=>$this->record->id])
                    ]),
                    Tabs\Tab::make('Order Items')
                    ->schema([
                        Livewire::make(ViewOrderItemTable::class,['id'=>$this->record->id])
                    ]),
                    Tabs\Tab::make('Invoices')
                    ->schema([
                        Livewire::make(ViewInvoiceTable::class,['id'=>$this->record->id])
                    ]),
                    Tabs\Tab::make('Payments')
                    ->schema([
                        Livewire::make(ViewPaymentTable::class,['id'=>$this->record->id])
                    ]),
                  
                ])
            ]);
    }
}
