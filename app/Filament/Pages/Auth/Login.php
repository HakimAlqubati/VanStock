<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as PagesLogin;
use Filament\Forms\Components\TextInput;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
 
class Login extends  PagesLogin
{
    /**
     * Override the form to set default values
     */

      public function mount(): void
    {
     

        $this->form->fill([
            'email' => 'admin@admin.com',
            'password' => '123456',
        ]);
    }
 
}
