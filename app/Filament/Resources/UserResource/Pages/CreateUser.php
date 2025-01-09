<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use App\Models\User;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected static bool $canCreateAnother = false;

    public  string $roleName ;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->roleName=$data['role'];
        return $data;
    }

    protected function afterCreate(): void
    {
        $user=User::find($this->record->id);
        $user->assignRole($this->roleName);
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
            ->body('The User has been created successfully.');
    }
}
