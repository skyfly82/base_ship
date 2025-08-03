<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Settlements;
use App\Models\Invoices;
use Carbon\Carbon;

class GenerateInvoices extends Command
{
    protected $signature = 'invoices:generate';
    protected $description = 'Generuj faktury dla klientów wg harmonogramu rozliczeń';

    public function handle()
    {
        // Pobierz klientów, którzy powinni mieć dziś generowaną fakturę
        $today = Carbon::now();

        $settlements = Settlements::where(function($q) use ($today) {
            $q->where('billing_cycle', 'instant')
              ->orWhere(function($q) use ($today) {
                  $q->where('billing_cycle', 'daily')
                    ->whereDate('next_billing_date', '<=', $today);
              })
              ->orWhere(function($q) use ($today) {
                  $q->where('billing_cycle', 'weekly')
                    ->where('weekly_billing_day', strtolower($today->englishDayOfWeek));
              })
              ->orWhere(function($q) use ($today) {
                  $q->where('billing_cycle', 'twice_monthly')
                    ->where(function($q2) use ($today) {
                        $q2->where('billing_day1', $today->day)
                           ->orWhere('billing_day2', $today->day);
                    });
              })
              ->orWhere(function($q) use ($today) {
                  $q->where('billing_cycle', 'monthly')
                    ->where('monthly_billing_day', $today->day);
              });
        })->get();

        foreach ($settlements as $settlement) {
            // TODO: Pobierz zamówienia/przesyłki do rozliczenia, wygeneruj fakturę
            $invoice = Invoices::create([
                'customer_id' => $settlement->customer_id,
                'settlement_id' => $settlement->id,
                'invoice_number' => 'FV' . now()->format('YmdHis') . rand(10,99),
                'issue_date' => $today,
                'billing_period_start' => $today->copy()->startOfMonth(),
                'billing_period_end' => $today,
                'amount_net' => 100,
                'amount_vat' => 23,
                'amount_gross' => 123,
                'currency' => 'PLN',
                'details' => json_encode(['test' => 'demo']),
            ]);
            $this->info("Faktura wygenerowana dla klienta: " . $invoice->invoice_number);
        }
    }
}
