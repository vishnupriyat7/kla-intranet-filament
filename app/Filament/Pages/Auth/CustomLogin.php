<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;

class CustomLogin extends BaseLogin
{
    protected static string $layout = 'filament-panels::components.layout.base';
    protected static string $view = 'filament.pages.auth.custom-login';
}
