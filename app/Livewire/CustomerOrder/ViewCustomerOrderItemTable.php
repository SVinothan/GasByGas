<?php

namespace App\Livewire\CustomerOrder;

use App\Models\CustomerOrderItem;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class ViewCustomerOrderItemTable extends Component implements HasForms, HasTable
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
            ->query(CustomerOrderItem::query()->where('customer_order_id',$this->id))
            ->columns([
                Tables\Columns\TextColumn::make('customerOrderItemCity.name_en')
                    ->label('City Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerOrderItemOutlet.outlet_name')
                    ->label('Outlet Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerOrderItemCustomer.full_name')
                    ->label('Customer Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerOrderItemDetail.name')
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
        return view('livewire.customer-order.view-customer-order-item-table');
    }
}
