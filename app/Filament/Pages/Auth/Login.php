<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Notifications\Notification;

class Login extends BaseLogin
{
    public function mount(): void
    {
        if (request()->session()->has('alert')) {
            Notification::make()
            ->title(request()->session()->get('alert'))
            ->warning()
            ->send();
        }
    }
}
