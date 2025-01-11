<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
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

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

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
                        'md'=>1,
                        'lg' => 1,
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->rules(['required'])->regex('/^[a-zA-Z\s]+$/u')->unique(table: Item::class, ignoreRecord:true),
                    ]),
                    Forms\Components\Grid::make([
                        'sm'=>1,
                        'md'=>3,
                        'lg' => 3,
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('height_in_meter')
                            ->extraInputAttributes(['style'=>'text-align:right'])
                            ->numeric()->rules(['required',fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                    if ($get('height_in_meter') <= '0.00' ) {
                                        $fail("The height of item must be greater than 0.");
                                    }
                                },
                            ]),
                        Forms\Components\TextInput::make('weight_in_kg')
                            ->extraInputAttributes(['style'=>'text-align:right'])
                            ->numeric()->rules(['required',fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                    if ($get('weight_in_kg') <= '0.00' ) {
                                        $fail("The Weight of item must be greater than 0.");
                                    }
                                },
                            ]),
                        // Forms\Components\TextInput::make('capacity')
                        //     ->extraInputAttributes(['style'=>'text-align:right'])
                        //     ->numeric()->rules(['required',fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                        //             if ($get('capacity') <= '0.00' ) {
                        //                 $fail("The capacity must be greater than 0.");
                        //             }
                        //         },
                        //     ]),
                        Forms\Components\ColorPicker::make('color')
                            
                    ])
                ])
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('height_in_meter')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('weight_in_kg')
                    ->numeric()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('capacity')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\ColorColumn::make('color')
                    ->searchable(),
                
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('')->toolTip('View Item'),
                Tables\Actions\EditAction::make()->label('')->toolTip('Edit Item'),
                Tables\Actions\DeleteAction::make()->label('')->toolTip('Delete Item'),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                //     Tables\Actions\ForceDeleteBulkAction::make(),
                //     Tables\Actions\RestoreBulkAction::make(),
                // ]),
            ])
            ->recordUrl(null);
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
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
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
