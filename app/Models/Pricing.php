<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;

    protected $table = 'pricings';

    protected $fillable = [
        'carrier_id', 'price', 'service_type', 'currency'
    ];
}
