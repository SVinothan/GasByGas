<?php

namespace App\Livewire\ScheduleDelivery;

use App\Models\ScheduleDeliveryStock;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class ViewScheduleDeliveryStockTable extends Component implements HasForms, HasTable
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
            ->query(ScheduleDeliveryStock::query()->where('schedule_delivery_id',$this->id))
            ->columns([

                Tables\Columns\TextColumn::make('scheduleDeliveryStockDistrict.name_en')
                    ->label('District Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('scheduleDeliveryStockCity.name_en')
                    ->label('City Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('scheduleDeliveryStockOutlet.outlet_name')
                    ->label('Outlet Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('scheduleDeliveryStockItem.name')
                    ->label('Item Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('batch_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('qty')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cost_price')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sales_price')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total')
                    ->searchable(),
                Tables\Columns\TextColumn::make('scheduled_date')
                    ->date()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
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
        return view('livewire.schedule-delivery.view-schedule-delivery-stock-table');
    }
}
