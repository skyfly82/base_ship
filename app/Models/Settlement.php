<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory;

    protected $table = 'settlements';

    protected $fillable = [
        'customer_id',
        'billing_cycle',
        'next_billing_date',
        'billing_day1',
        'billing_day2',
        'monthly_billing_day',
        'weekly_billing_day'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
