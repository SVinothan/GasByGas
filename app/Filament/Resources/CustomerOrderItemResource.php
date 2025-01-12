<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerOrderItemResource\Pages;
use App\Filament\Resources\CustomerOrderItemResource\RelationManagers;
use App\Models\CustomerOrderItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerOrderItemResource extends Resource
{
    protected static ?string $model = CustomerOrderItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Consumer';

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
                Tables\Columns\TextColumn::make('customerOrderItemCity.name_en')
                    ->label('City Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerOrderItemOutlet.outlet_name')
                    ->label('Outlet Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerOrderItemCustomer.fist_name')
                    ->label('First Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerOrderItemCustomer.last_name')
                    ->label('Last Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_date')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customerOrderItemDetail.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                 
            ])
            ->filters([
            ])
            ->actions([
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
            'index' => Pages\ListCustomerOrderItems::route('/'),
            // 'create' => Pages\CreateCustomerOrderItem::route('/create'),
            // 'edit' => Pages\EditCustomerOrderItem::route('/{record}/edit'),
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
