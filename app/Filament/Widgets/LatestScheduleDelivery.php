<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\ScheduleDelivery;

class LatestScheduleDelivery extends BaseWidget
{
    public function table(Table $table): Table
    {
        if(auth()->user()->getRoleNames()->first() == 'Customer')
        {
            return $table
                ->query(
                    ScheduleDelivery::where('status','Scheduled')->where('city_id',auth()->user()->userCustomer->city_id)->orderBy('updated_at','desc')->limit(5)
                )
                ->columns([
                    Tables\Columns\TextColumn::make('scheduleDeliveryOutlet.outlet_name')
                        ->label('Outlet Name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('schedule_no')
                        ->label('Schedule Code')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('scheduled_date')
                        ->date()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('no_of_item')
                        ->searchable()->label('Items'),
                    Tables\Columns\TextColumn::make('no_of_qty')
                        ->searchable()->label('Qtys'),
                ]);
        }
        else if(auth()->user()->getRoleNames()->first() == 'OutletManager')
        {
            return $table
                ->query(
                    ScheduleDelivery::where('status','Scheduled')->where('outlet_id',auth()->user()->userEmployee->outlet_id)->orderBy('updated_at','desc')->limit(5)
                )
                ->columns([
                    Tables\Columns\TextColumn::make('schedule_no')
                        ->label('Schedule Code')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('scheduled_date')
                        ->date()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('no_of_item')
                        ->searchable()->label('Items'),
                    Tables\Columns\TextColumn::make('no_of_qty')
                        ->searchable()->label('Qtys'),
                ]);
        }
        else
        {
            return $table
                ->query(
                    ScheduleDelivery::where('status','Scheduled')->orderBy('updated_at','desc')->limit(5)
                )
                ->columns([
                    Tables\Columns\TextColumn::make('scheduleDeliveryCity.name_en')
                        ->label('City Name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('scheduleDeliveryOutlet.outlet_name')
                        ->label('Outlet Name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('schedule_no')
                        ->label('Schedule Code')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('scheduled_date')
                        ->date()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('no_of_item')
                        ->searchable()->label('Items'),
                    Tables\Columns\TextColumn::make('no_of_qty')
                        ->searchable()->label('Qtys'),
                ]);
        }
    }
}
