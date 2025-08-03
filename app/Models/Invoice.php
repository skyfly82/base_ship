<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = [
        'customer_id', 'settlement_id', 'invoice_number',
        'issue_date', 'billing_period_start', 'billing_period_end',
        'amount_net', 'amount_vat', 'amount_gross', 'currency', 'details'
    ];

    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_id');
    }

    public function settlement()
    {
        return $this->belongsTo(Settlements::class, 'settlement_id');
    }
}
