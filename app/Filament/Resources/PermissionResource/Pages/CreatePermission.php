<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use App\Filament\Resources\PermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Model;

class CreatePermission extends CreateRecord
{
    protected static string $resource = PermissionResource::class;
    protected static bool $canCreateAnother = false;

    public  $arrayName = array( 
        '0'=>'View',
        '1'=>'ViewAny',
        '2'=>'Create',
        '3'=>'Update',
        '4'=>'Delete',
        '5'=>'Restore',
    );

   

    protected function handleRecordCreation(array $data): Model
    {
        for ($i=0; $i < 6; $i++) { 
            if(Permission::where('name',$this->arrayName[$i].'_'.$data['model_name'])->count() > 0)
            {
                Notification::make()
                ->warning()
                ->title('Warning!!')
                ->body('This Permission is already created.')
                ->send();

                $this->halt();
            }

            $permission = new Permission;
            $permission->name = $this->arrayName[$i].'_'.$data['model_name'];
            $permission->guard_name = 'web';
            $permission->save();

        }
        return $permission;
    }

    public function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    

    public function getCreatedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title('Succcess')
            ->body('The Permission has been created successfully.');
    }
}
