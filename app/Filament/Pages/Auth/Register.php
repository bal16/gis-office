<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
// use Filament\Notifications\Notification;


class Register extends BaseRegister
{
    protected function getEmailFormComponent(): Component
    {
        $emailEndsEnv = env('APP_EMAIL', '@tabel.dev');
        $emailEnds = preg_quote($emailEndsEnv);

        return TextInput::make('email')
            ->label(__('filament-panels::pages/auth/register.form.email.label'))
            ->email()
            ->regex("/[-\w\.]+$emailEnds/")
            ->validationMessages([
                'regex' => "The :attribute must be ends with $emailEndsEnv",
            ])
            ->required()
            ->maxLength(255)
            ->unique($this->getUserModel());
    }
    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('filament-panels::pages/auth/register.form.password.label'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->regex('/^(?=.*[a-zA-Z])(?=.*[0-9]).*$/')
            ->rule(Password::sometimes())
            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
            ->same('passwordConfirmation')
            ->validationMessages([
                'regex' => 'The :attribute must be contain letter and number.',
            ])
            ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute'));
    }

}
