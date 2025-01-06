<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProvinceResource\Pages;
use App\Filament\Resources\ProvinceResource\RelationManagers;
use App\Models\Province;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\MaxWidth;
use Filament\Notifications\Notification;

class ProvinceResource extends Resource
{
    protected static ?string $model = Province::class;

    protected static ?string $navigationIcon = 'heroicon-o-server';
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
                Tables\Columns\TextColumn::make('name_en')
                    ->searchable(),
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('')->toolTip('Edit Province')
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
                            Forms\Components\TextInput::make('name_en')->regex('/^[a-zA-Z\s]+$/u')->label('Province Name')
                                ->maxLength(191)->unique(table: Branch::class, ignoreRecord:true)->rules(['required']),
                                ])
                            ])
                    ])
                    ->action(function (Province $record, array $data){
                        $province = Province::find($record->id);
                        $province->name_en = $data['name_en'];
                        $province->user_id = auth()->user()->id;
                        $province->update();
    
                        Notification::make()
                            ->success()
                            ->title('Succcess')
                            ->body('The Province has been updated successfully.')
                            ->send();
                    })
                    ->modalWidth(MaxWidth::Small),
                Tables\Actions\DeleteAction::make()->label('')->toolTip('Delete Province')
                    ->action(function (District $record)
                    {
                        District::where('province_id',$record->id)->delete();
                        City::where('province_id',$record->id)->delete();
                        $record->delete();

                        Notification::make()
                            ->success()
                            ->title('Succcess')
                            ->body('The Province has been deleted successfully.')
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
            'index' => Pages\ListProvinces::route('/'),
            // 'create' => Pages\CreateProvince::route('/create'),
            // 'edit' => Pages\EditProvince::route('/{record}/edit'),
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
