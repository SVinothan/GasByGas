<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityResource\Pages;
use App\Filament\Resources\CityResource\RelationManagers;
use App\Models\City;
use App\Models\Province;
use App\Models\District;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Get;
use Closure;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $navigationGroup = 'Settings';

    public static function getNavigationSort(): ?int
    {
        return 23;
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
                Tables\Columns\TextColumn::make('cityProvince.name_en')
                    ->label('Province Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cityDistrict.name_en')
                    ->label('District Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name_en')
                    ->label('City Name')
                    ->searchable(),
                
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('')->toolTip('Edit City')
                    ->form([
                        Forms\Components\Section::make('')
                            ->description('')
                            ->schema([
                                Forms\Components\Grid::make([
                                    'sm'=>1,
                                    'md'=>1,
                                    'lg' => 1,
                                ])
                                ->schema([
                                    Forms\Components\Select::make('province_id')->label('Select Province')
                                        ->options(Province::pluck('name_en','id'))->rules(['required'])->searchable(),
                                    Forms\Components\Select::make('district_id')->label('Select District')
                                        ->options(fn (Get $get) => District::where('province_id',$get('province_id'))->pluck('name_en','id'))->rules(['required'])->searchable(),
                                    Forms\Components\TextInput::make('name_en')->regex('/^[a-zA-Z\s]+$/u')->label('City Name')
                                        ->maxLength(191)->unique(table: City::class, ignoreRecord:true)->rules(['required']),
                                ])
                            ])
                    ])
                    ->action(function (City $record, array $data){
                        $city = City::find($record->id);
                        $city->name_en = $data['name_en'];
                        $city->province_id = $data['province_id'];
                        $city->district_id = $data['district_id'];
                        $city->user_id = auth()->user()->id;
                        $city->save();
        
                        Notification::make()
                            ->success()
                            ->title('Succcess')
                            ->body('The City has been updated successfully.')
                            ->send();
                    })
                    ->modalWidth(MaxWidth::Small),
                Tables\Actions\DeleteAction::make()->label('')->toolTip('Delete City'),
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
            'index' => Pages\ListCities::route('/'),
            // 'create' => Pages\CreateCity::route('/create'),
            // 'edit' => Pages\EditCity::route('/{record}/edit'),
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
