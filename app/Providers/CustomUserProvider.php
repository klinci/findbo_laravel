<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\User;

class CustomUserProvider extends ServiceProvider
{
    public function validateCredentials(User $user, array $credentials)
    {
        $plain = $credentials['password'];
        
        $password = password_verify($plain, $user->password);

        return $this->hasher->check($plain, $user->getAuthPassword());
    }
}