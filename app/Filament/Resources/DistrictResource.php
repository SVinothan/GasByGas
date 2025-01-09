<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DistrictResource\Pages;
use App\Filament\Resources\DistrictResource\RelationManagers;
use App\Models\Province;
use App\Models\District;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\MaxWidth;
use Filament\Notifications\Notification;

class DistrictResource extends Resource
{
    protected static ?string $model = District::class;

    protected static ?string $navigationIcon = 'heroicon-o-server-stack';
    protected static ?string $navigationGroup = 'Settings';

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
                Tables\Columns\TextColumn::make('districtProvince.name_en')
                    ->searchable()->label('Province Name'),
                Tables\Columns\TextColumn::make('name_en')
                    ->searchable()->label('District Name'),
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('')->toolTip('Edit District')
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
                                    Forms\Components\TextInput::make('name_en')->regex('/^[a-zA-Z\s]+$/u')->label('District Name')
                                        ->maxLength(191)->unique(table: District::class, ignoreRecord:true)->rules(['required']),
                                ])
                            ])
                    ])
                    ->action(function (District $record, array $data){
                        $district = District::find($record->id);
                        $district->name_en = $data['name_en'];
                        $district->province_id = $data['province_id'];
                        $district->user_id = auth()->user()->id;
                        $district->update();

                        Notification::make()
                            ->success()
                            ->title('Succcess')
                            ->body('The District has been updated successfully.')
                            ->send();
                    })
                    ->modalWidth(MaxWidth::Small),
                Tables\Actions\DeleteAction::make()->label('')->toolTip('Delete District')
                    ->action(function (District $record)
                    {
                        City::where('district_id',$record->id)->delete();
                        $record->delete();

                        Notification::make()
                            ->success()
                            ->title('Succcess')
                            ->body('The District has been deleted successfully.')
                            ->send();
                    }),
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
            'index' => Pages\ListDistricts::route('/'),
            // 'create' => Pages\CreateDistrict::route('/create'),
            // 'edit' => Pages\EditDistrict::route('/{record}/edit'),
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
