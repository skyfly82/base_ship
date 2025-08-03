<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SystemUser extends Authenticatable
{
    use HasFactory;

    protected $table = 'system_users';

    protected $fillable = [
        'name', 'email', 'password', 'role', 'active',
    ];
}
