<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerInvoiceItemResource\Pages;
use App\Filament\Resources\CustomerInvoiceItemResource\RelationManagers;
use App\Models\CustomerInvoiceItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerInvoiceItemResource extends Resource
{
    protected static ?string $model = CustomerInvoiceItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';
    protected static ?string $navigationGroup = 'Consumer';

    public static function getNavigationSort(): ?int
    {
        return 15;
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
                Tables\Columns\TextColumn::make('customerInvoiceItemCity.name_en')
                    ->label('City Name')
                    ->searchable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' || auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),
                Tables\Columns\TextColumn::make('customerInvoiceItemOutlet.outlet_name')
                    ->label('Outlet Name')
                    ->searchable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' ? true : false),
                Tables\Columns\TextColumn::make('customerInvoiceItemCustomer.full_name')
                    ->label('Customer Name')
                    ->searchable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),
                Tables\Columns\TextColumn::make('customerInvoiceItemCustomer.mobile_no')
                    ->label('Customer Mobile')
                    ->searchable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),
                Tables\Columns\TextColumn::make('customerInvoiceDetail.token_no')
                    ->label('Token')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerInvoiceItemDetail.name')
                    ->label('Item Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('qty')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total')
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
            'index' => Pages\ListCustomerInvoiceItems::route('/'),
            // 'create' => Pages\CreateCustomerInvoiceItem::route('/create'),
            // 'edit' => Pages\EditCustomerInvoiceItem::route('/{record}/edit'),
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
