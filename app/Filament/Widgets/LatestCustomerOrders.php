<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\CustomerOrder;

class LatestCustomerOrders extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                CustomerOrder::where('status','Order Pending')->orderBy('updated_at','desc')->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('customerOrderCity.name_en')
                    ->label('City Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerOrderOutlet.outlet_name')
                    ->label('Outlet Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerOrderCustomer.full_name')
                    ->label('Customer Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('token_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pickup_date')
                    ->searchable(),
            ]);
    }
}
