<?php

namespace App\Livewire\CustomerInvoice;

use App\Models\CustomerInvoiceItem;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class ViewCustomerInvoiceItemTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public $id;

    public function mount($id = '')
    {
        $this->id = $id;    
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(CustomerInvoiceItem::query()->where('customer_invoice_id',$this->id))
            ->columns([
                Tables\Columns\TextColumn::make('customerInvoiceItemCity.name_en')
                    ->label('City Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerInvoiceItemOutlet.outlet_name')
                    ->label('Outlet Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerInvoiceItemCustomer.full_name')
                    ->label('Customer Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerInvoiceItemDetail.name')
                    ->label('Item Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('qty')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sales_price')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.customer-invoice.view-customer-invoice-item-table');
    }
}
