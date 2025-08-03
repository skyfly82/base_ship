<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'active',
        'company_name', 'tax_id', 'customer_type',
        'country', 'city', 'postal_code', 'street',
        'building_number', 'apartment_number'
    ];
}
