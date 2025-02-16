<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data['passwordConfirmation'] !== $data['password'] ) 
        {
            Notification::make()
                ->title('Warning!!')
                ->body('Please check your confirm password!!')
                ->warning()
                ->send();
            $this->halt();
        }
        $data['password'] = bcrypt($data['password']);
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title('Succcess')
            ->body('The User has been Updated successfully.');
    }
    
    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
            // Actions\ForceDeleteAction::make(),
            // Actions\RestoreAction::make(),
        ];
    }
}
