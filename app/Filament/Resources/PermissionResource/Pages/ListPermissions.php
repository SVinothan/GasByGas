<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use App\Filament\Resources\PermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\TextInput;
use App\Models\Permission;
use Filament\Notifications\Notification;
use Filament\Support\Enums\MaxWidth;

class ListPermissions extends ListRecords
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create New')->toolTip('Create model Permission'),
            Actions\Action::make('SinglePermission')->label('New Single Permission')->toolTip('Create Single Permission')
            ->form([
                    TextInput::make('name')->rules(['required']),
                    TextInput::make('guard_name')->default('web')->readOnly(),  
                ])
                ->action(function (array $data){
                    if(Permission::where('name',$data['name'])->count() > 0)
                    {
                        Notification::make()
                        ->warning()
                        ->title('Warning!!')
                        ->body('This Permission is already created.')
                        ->send();

                        $this->halt();
                    }
                    $permission = new Permission;
                    $permission->name=$data['name'];
                    $permission->guard_name=$data['guard_name'];
                    $permission->save();

                    Notification::make()
                    ->success()
                    ->title('Success!!')
                    ->body('The Permission  Created Successfully.')
                    ->send();

                })->modalWidth(MaxWidth::Small)
        ];
    }
}
