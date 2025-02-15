<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockResource\Pages;
use App\Filament\Resources\StockResource\RelationManagers;
use App\Models\Stock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\Summarizers\Sum;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Item';

    public static function getNavigationSort(): ?int
    {
        return 2;
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
                Tables\Columns\TextColumn::make('stockProvince.name_en')
                    ->label('Province Name')
                    ->sortable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' ? true : false),
                Tables\Columns\TextColumn::make('stockDistrict.name_en')
                    ->label('District Name')
                    ->sortable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' ? true : false),
                Tables\Columns\TextColumn::make('stockCity.name_en')
                    ->label('City Name')
                    ->sortable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' ? true : false),
                Tables\Columns\TextColumn::make('stockOutlet.outlet_name')
                    ->label('Outlet Name')
                    ->sortable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' ? true : false),
                Tables\Columns\TextColumn::make('stockItem.name')
                    ->label('Item Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('qty')
                    ->sortable(),
                Tables\Columns\TextColumn::make('batch_no')
                    ->searchable()->label('Batch Number'),
                Tables\Columns\TextColumn::make('cost_price')
                    ->alignment(Alignment::End)
                    ->sortable(),
                Tables\Columns\TextColumn::make('sales_price')
                    ->alignment(Alignment::End)
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock_amount')->label('Stock Amount')
                    ->state(function (Stock $stock) {
                        return number_format($stock->qty * $stock->cost_price , 2);
                    })
                    ->alignment(Alignment::End)
                    ->sortable(),
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
            'index' => Pages\ListStocks::route('/'),
            // 'create' => Pages\CreateStock::route('/create'),
            // 'edit' => Pages\EditStock::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                // SoftDeletingScope::class,
            ]);
    }
}
