<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'carrier_id', 'order_id', 'tracking_number', 'status',
        'length_cm', 'width_cm', 'height_cm', 'weight_kg', 'billing_weight_kg',
        'details', 'system_user_id'
    ];
}
