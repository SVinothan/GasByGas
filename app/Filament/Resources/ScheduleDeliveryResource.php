<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleDeliveryResource\Pages;
use App\Filament\Resources\ScheduleDeliveryResource\RelationManagers;
use App\Models\ScheduleDelivery;
use App\Models\Province;
use App\Models\District;
use App\Models\City;
use App\Models\Outlet;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Closure;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\Summarizers\Sum;

class ScheduleDeliveryResource extends Resource
{
    protected static ?string $model = ScheduleDelivery::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                        Forms\Components\Select::make('province_id')->label('Select Province')->rules(['required'])
                            ->options(Province::whereIn('id',Outlet::pluck('province_id'))->pluck('name_en','id'))->rules(['required'])->searchable(),
                        Forms\Components\Select::make('district_id')->label('Select District')->rules(['required'])
                            ->options(fn (Get $get) => District::where('province_id',$get('province_id'))->whereIn('id',Outlet::pluck('district_id'))->pluck('name_en','id'))->rules(['required'])->searchable(),
                        Forms\Components\Select::make('city_id')->label('Select City')->rules(['required'])
                            ->options(fn (Get $get) => City::where('district_id',$get('district_id'))->whereIn('id',Outlet::pluck('city_id'))->pluck('name_en','id'))->rules(['required'])->searchable(),
                    ]),
                    Forms\Components\Grid::make([
                        'sm'=>1,
                        'md'=>2,
                        'lg' => 2,
                    ])
                    ->schema([
                        Forms\Components\Select::make('outlet_id')->label('Select Outlet')
                            ->options(fn (Get $get) => Outlet::where('city_id',$get('city_id'))->pluck('outlet_name','id'))->rules(['required'])->searchable(),
                        Forms\Components\DatePicker::make('scheduled_date')->rules(['required'])->native(false)->minDate(now()),
                    ])
                    ]),
                Forms\Components\Section::make('')
                ->description('')
                ->schema([
                    Forms\Components\Repeater::make('Stock')
                    ->relationship('scheduleDeliveryStocks')
                    ->schema([
                        Forms\Components\Grid::make([
                            'sm'=>1,
                            'md'=>3,
                            'lg' => 3,
                        ])
                        ->schema([
                            Forms\Components\Select::make('item_id')->label('Select Item')
                                ->options(fn (Get $get) => Item::pluck('name','id'))->rules(['required'])->searchable(),
                            Forms\Components\TextInput::make('batch_no')
                                ->numeric()->rules(['required'])->label('Batch Number'),
                            Forms\Components\TextInput::make('qty')
                                ->extraInputAttributes(['style'=>'text-align:right'])
                                ->numeric()->rules(['required',fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                        if ($get('qty') <= '0.00' ) {
                                            $fail("The Quantity of item must be greater than 0.");
                                        }
                                    },
                                ]),
                        ]),
                        Forms\Components\Grid::make([
                            'sm'=>1,
                            'md'=>2,
                            'lg' => 2,
                        ])
                        ->schema([
                                Forms\Components\TextInput::make('cost_price')
                                ->extraInputAttributes(['style'=>'text-align:right'])
                                ->numeric()->rules(['required',fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                        if ($get('cost_price') <= '0.00' ) {
                                            $fail("The Cost Price must be greater than 0.");
                                        }
                                    },
                                ]),
                                Forms\Components\TextInput::make('sales_price')
                                ->extraInputAttributes(['style'=>'text-align:right'])
                                ->numeric()->rules(['required',fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                        if ($get('sales_price') <= '0.00') {
                                            $fail("The Selling Price must be greater than 0.");
                                        }
                                        if ($get('sales_price') < $get('cost_price')) {
                                            $fail("The Selling Price must be greater than cost price.");
                                        }
                                    },
                                ]),
                        ])
                    ])
                ])
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                 
                Tables\Columns\TextColumn::make('scheduleDeliveryDistrict.name_en')
                    ->label('District Name')
                    ->searchable(),
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
                Tables\Columns\TextColumn::make('amount')
                    ->searchable()->alignment(Alignment::End)->summarize(Sum::make()->numeric(decimalPlaces: 2,)->label('Total')),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('')->toolTip('View Schedule Delivery'),
                Tables\Actions\EditAction::make()->label('')->toolTip('Edit Schedule Delivery'),
                Tables\Actions\DeleteAction::make()->label('')->toolTip('Delete Schedule Delivery'),
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
            'index' => Pages\ListScheduleDeliveries::route('/'),
            'create' => Pages\CreateScheduleDelivery::route('/create'),
            'edit' => Pages\EditScheduleDelivery::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->orderBy('updated_at','desc')
            ->withoutGlobalScopes([
                // SoftDeletingScope::class,
            ]);
    }
}
