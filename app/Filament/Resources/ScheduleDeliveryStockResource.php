<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleDeliveryStockResource\Pages;
use App\Filament\Resources\ScheduleDeliveryStockResource\RelationManagers;
use App\Models\ScheduleDeliveryStock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScheduleDeliveryStockResource extends Resource
{
    protected static ?string $model = ScheduleDeliveryStock::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Item';

    public static function getNavigationSort(): ?int
    {
        return 4;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                Tables\Columns\TextColumn::make('scheduleDeliveryDetail.schedule_no')
                    ->label('Schedule Code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('scheduleDeliveryStockItem.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('batch_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('qty')
                    ->searchable(),
                Tables\Columns\TextColumn::make('scheduled_date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cost_price')
                    ->searchable(),
                
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                //     Tables\Actions\ForceDeleteBulkAction::make(),
                //     Tables\Actions\RestoreBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListScheduleDeliveryStocks::route('/'),
            // 'create' => Pages\CreateScheduleDeliveryStock::route('/create'),
            // 'edit' => Pages\EditScheduleDeliveryStock::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->getRoleNames()->first() == 'OutletManager')
        {
            return parent::getEloquentQuery()
            ->where('outlet_id',auth()->user()->userEmployee->outlet_id)
            ->withoutGlobalScopes([
                // SoftDeletingScope::class,
            ]);
        }
        else
        {
            return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                // SoftDeletingScope::class,
            ]);
        }
    }
}
