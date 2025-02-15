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
        if(auth()->user()->getRoleNames()->first() == 'Customer')
        {
            return $table
                ->query(
                    CustomerOrder::where('status','Order Pending')->where('customer_id',auth()->user()->customer_id)->orderBy('updated_at','desc')->limit(5)
                )
                ->columns([
                    Tables\Columns\TextColumn::make('customerOrderOutlet.outlet_name')
                        ->label('Outlet Name')
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
        else if(auth()->user()->getRoleNames()->first() == 'OutletManager')
        {
            return $table
                ->query(
                    CustomerOrder::where('status','Order Pending')->where('outlet_id',auth()->user()->userEmployee->outlet_id)->orderBy('updated_at','desc')->limit(5)
                )
                ->columns([
                    Tables\Columns\TextColumn::make('customerOrderCustomer.full_name')
                        ->label('Customer Name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('customerOrderCustomer.mobile_no')
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
        else
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
}
