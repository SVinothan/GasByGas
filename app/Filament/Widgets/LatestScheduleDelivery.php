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
