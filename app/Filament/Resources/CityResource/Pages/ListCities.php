<?php

namespace App\Filament\Resources\CityResource\Pages;

use App\Filament\Resources\CityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Province;
use App\Models\District;
use App\Models\City;
use Filament\Notifications\Notification;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Closure;

class ListCities extends ListRecords
{
    protected static string $resource = CityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('create')->label('Create New')->toolTip('Create New City')
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
            ->action(function (array $data){
                $city = new City;
                $city->name_en = $data['name_en'];
                $city->province_id = $data['province_id'];
                $city->district_id = $data['district_id'];
                $city->user_id = auth()->user()->id;
                $city->save();

                Notification::make()
                    ->success()
                    ->title('Succcess')
                    ->body('The City has been created successfully.')
                    ->send();
            })
            ->modalWidth(MaxWidth::Small),
        ];
    }
}
