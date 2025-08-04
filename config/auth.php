<?php

return [

    // Domyślny "guard" i "passwords"
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    // Dostępne guardy autoryzacji
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],

        // Guard dla systemowych użytkowników (system_users)
        'systemuser' => [
            'driver' => 'session',
            'provider' => 'system_users',
        ],
    ],

    // Dostępne providery użytkowników
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // Provider dla systemowych użytkowników (system_users)
        'system_users' => [
            'driver' => 'eloquent',
            'model' => App\Models\SystemUser::class,
        ],
    ],

    // Resetowanie haseł
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        // Jeśli chcesz osobne resetowanie haseł dla system_users, dodaj:
        // 'system_users' => [
        //     'provider' => 'system_users',
        //     'table' => 'system_user_password_resets',
        //     'expire' => 60,
        //     'throttle' => 60,
        // ],
    ],

    // Czas ważności sesji resetowania hasła
    'password_timeout' => 10800,

];
