<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OutletResource\Pages;
use App\Filament\Resources\OutletResource\RelationManagers;
use App\Models\Outlet;
use App\Models\Province;
use App\Models\District;
use App\Models\City;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Closure;

class OutletResource extends Resource
{
    protected static ?string $model = Outlet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')
                ->description('')
                ->schema([
                    Forms\Components\Grid::make([
                        'sm'=>1,
                        'md'=>3,
                        'lg' => 3,
                    ])
                    ->schema([
                        Forms\Components\Select::make('province_id')->label('Select Province')
                            ->options(Province::pluck('name_en','id'))->rules(['required'])->searchable(),
                        Forms\Components\Select::make('district_id')->label('Select District')
                            ->options(fn (Get $get) => District::where('province_id',$get('province_id'))->pluck('name_en','id'))->rules(['required'])->searchable(),
                        Forms\Components\Select::make('city_id')->label('Select City')
                            ->options(fn (Get $get) => City::where('district_id',$get('district_id'))->pluck('name_en','id'))->rules(['required'])->searchable(),
                    ]),
                    Forms\Components\Grid::make([
                        'sm'=>1,
                        'md'=>2,
                        'lg' => 2,
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('outlet_name')->label('City Name')
                            ->maxLength(191)->unique(table: Outlet::class, ignoreRecord:true)->rules(['required']),
                        Forms\Components\Textarea::make('address')->rules(['required'])
                    ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('outletProvince.name_en')
                    ->label('Province Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('outletDistrict.name_en')
                    ->label('District Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('outletCity.name_en')
                    ->label('District Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('outlet_name')
                    ->searchable(),
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('')->toolTip('View Outlet'),
                Tables\Actions\EditAction::make()->label('')->toolTip('Edit Outlet'),
                Tables\Actions\DeleteAction::make()->label('')->toolTip('Delete Outlet'),
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
            'index' => Pages\ListOutlets::route('/'),
            'create' => Pages\CreateOutlet::route('/create'),
            'edit' => Pages\EditOutlet::route('/{record}/edit'),
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
