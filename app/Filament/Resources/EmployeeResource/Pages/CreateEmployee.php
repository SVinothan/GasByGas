<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Filament\Notifications\Notification;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;
    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->user()->id;
        return $data;
    }

    protected function afterCreate()
    {
        $data = $this->record;
        $role = Role::find($data->role_id);
        $user = new User;
        $user->name = $data->full_name;
        $user->role = $role->name;
        $user->employee_id = $data->id;
        $user->email = $data->email;
        $user->password = bcrypt($user->nic_no);
        $user->save();

        $user->assignRole($role->name);
        $data->update(['user_table_id'=>$user->id]);
    }
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title('Succcess')
            ->body('The Employee has been created successfully.');
    }
}
