<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('updatePassword')->form([
                TextInput::make('password')
                ->password()
                ->confirmed()
                ->required(),
                TextInput::make('password_confirmation')
                ->password()
                ->required()
            ])->action(function ($data){
                $this->record->update(['password'=>$data['password']]);
                Notification::make()->title('Password Updated')->success()->send();
            })
        ];
    }
}
