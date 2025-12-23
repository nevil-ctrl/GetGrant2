<?php

use Laravel\Fortify\Features;

return [
    'guard' => 'web',
    'passwords' => 'users',
    'username' => 'email',
    'email' => 'email',
    'lowercase_usernames' => true,
    'home' => '/dashboard',

    // ✅ ВАЖНО: Убираем префикс 'auth' для React SPA
    // Теперь маршруты будут: /login, /register, /logout
    // Вместо: /auth/login, /auth/register, /auth/logout
    'prefix' => '',

    'domain' => null,
    'middleware' => ['web'],

    'limiters' => [
        'login' => 'login',
        'two-factor' => 'two-factor',
    ],

    // ✅ ВАЖНО: views = false для React SPA
    'views' => false,

    'features' => [
        Features::registration(),
        Features::resetPasswords(),
        Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
        Features::twoFactorAuthentication([
            'confirm' => true,
            'confirmPassword' => true,
        ]),
    ],
];
