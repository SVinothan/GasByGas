<?php

namespace App\Filament\Resources\DistrictResource\Pages;

use App\Filament\Resources\DistrictResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Province;
use App\Models\District;
use Filament\Notifications\Notification;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms;
use Filament\Forms\Form;

class ListDistricts extends ListRecords
{
    protected static string $resource = DistrictResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('create')->label('Create New')->toolTip('Create New District')
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
            ->action(function (array $data){
                $district = new District;
                $district->name_en = $data['name_en'];
                $district->province_id = $data['province_id'];
                $district->user_id = auth()->user()->id;
                $district->save();

                Notification::make()
                    ->success()
                    ->title('Succcess')
                    ->body('The District has been created successfully.')
                    ->send();
            })
            ->modalWidth(MaxWidth::Small),
        ];
    }
}
