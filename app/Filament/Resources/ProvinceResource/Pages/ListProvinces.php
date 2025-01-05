<?php

namespace App\Filament\Resources\ProvinceResource\Pages;

use App\Filament\Resources\ProvinceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms;
use Filament\Forms\Form;
use App\Models\Province;
use Filament\Notifications\Notification;

class ListProvinces extends ListRecords
{
    protected static string $resource = ProvinceResource::class;
    protected static bool $canCreateAnother = false;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('create')->label('Create New')->toolTip('Create New Province')
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
                                ->maxLength(191)->unique(table: Branch::class, ignoreRecord:true),
                            ])
                        ])
                ])
                ->action(function (array $data){
                    $province = new Province;
                    $province->name_en = $data['name_en'];
                    $province->user_id = auth()->user()->id;
                    $province->save();

                    Notification::make()
                        ->success()
                        ->title('Succcess')
                        ->body('The Province has been created successfully.')
                        ->send();
                })
                ->modalWidth(MaxWidth::Small),
        ];
    }
}
