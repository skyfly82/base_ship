<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipment extends Model
{
    use HasFactory;

    protected $table = 'shipments';

    protected $fillable = [
        'customer_id', 'carrier_id', 'order_id', 'tracking_number', 'status',
        'length_cm', 'width_cm', 'height_cm', 'weight_kg', 'billing_weight_kg',
        'details', 'system_user_id'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function carrier() {
        return $this->belongsTo(Carrier::class, 'carrier_id');
    }
    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function systemUser() {
        return $this->belongsTo(SystemUser::class, 'system_user_id');
    }
}
