<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class SystemUser extends Authenticatable
{
    protected $table = 'system_users';

    protected $fillable = [
        'login', 'password', 'email', 'role', 'active',
    ];

    protected $hidden = [
        'password',
    ];
}

