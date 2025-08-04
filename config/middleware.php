<?php

return [
    // Globalne middleware (działają na wszystkie requesty)
    'global' => [
        // \Illuminate\Http\Middleware\TrustProxies::class,
        // \Illuminate\Http\Middleware\HandleCors::class,
        // \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        // itp...
    ],

    // Aliasowane middleware (używane per trasa)
    'aliases' => [
        'auth' => Illuminate\Auth\Middleware\Authenticate::class,
        'guest' => Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,
        // Dodaj tu swój middleware:
        'systemuser.auth' => App\Http\Middleware\SystemUserAuth::class,
    ],
];
