<?php

namespace App\Livewire\Customer;

use App\Models\CustomerOrder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class ViewOrderTable extends Component implements HasForms, HasTable
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
            ->query(CustomerOrder::query()->where('customer_id',$this->id))
            ->columns([
                // Tables\Columns\TextColumn::make('customerOrderCity.name_en')
                //     ->label('City Name')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('customerOrderOutlet.outlet_name')
                    ->label('Outlet Name')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('customerOrderCustomer.full_name')
                //     ->label('Customer Name')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('token_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pickup_date')
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
        return view('livewire.customer.view-order-table');
    }
}
