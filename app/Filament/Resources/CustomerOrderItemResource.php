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

    public static function getNavigationSort(): ?int
    {
        return 13;
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
                Tables\Columns\TextColumn::make('customerOrderItemCity.name_en')
                    ->label('City Name')
                    ->searchable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' || auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),
                Tables\Columns\TextColumn::make('customerOrderItemOutlet.outlet_name')
                    ->label('Outlet Name')
                    ->searchable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' ? true : false),
                Tables\Columns\TextColumn::make('customerOrderItemCustomer.full_name')
                    ->label('Customer Name')
                    ->searchable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),
                Tables\Columns\TextColumn::make('customerOrderItemCustomer.mobile_no')
                    ->label('Customer Mobile')
                    ->searchable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),
                Tables\Columns\TextColumn::make('customerOrderDetail.token_no')
                    ->label('Token')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerOrderItemDetail.name')
                    ->label('Item Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('qty')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sales_price')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total')
                    ->searchable(),
                 
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
        if(auth()->user()->getRoleNames()->first() == 'OutletManager')
        {
            return parent::getEloquentQuery()
            ->where('outlet_id',auth()->user()->userEmployee->outlet_id)
            ->withoutGlobalScopes([
                // SoftDeletingScope::class,
            ]);
        }
        else if(auth()->user()->getRoleNames()->first() == 'Customer')
        {
            return parent::getEloquentQuery()
            ->where('customer_id',auth()->user()->customer_id)
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
