<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Models\Settlement;

class CustomerAndSettlementSeeder extends Seeder
{
    public function run()
    {
        $customers = [
            [
                'name' => 'Jan Kowalski',
                'email' => 'jan.kowalski@example.com',
                'phone' => '600700800',
                'password' => Hash::make('password'),
                'customer_type' => 'b2c',
                'country' => 'PL',
                'city' => 'Warszawa',
                'postal_code' => '00-001',
                'street' => 'Nowa',
                'building_number' => '1',
                'apartment_number' => '12',
                'active' => true,
            ],
            [
                'name' => 'Firma ABC Sp. z o.o.',
                'email' => 'kontakt@firmaabc.pl',
                'phone' => '666123456',
                'password' => Hash::make('password'),
                'customer_type' => 'b2b',
                'company_name' => 'Firma ABC Sp. z o.o.',
                'tax_id' => '5211234567',
                'country' => 'PL',
                'city' => 'Kraków',
                'postal_code' => '30-002',
                'street' => 'Stara',
                'building_number' => '5A',
                'apartment_number' => null,
                'active' => true,
            ],
        ];

        foreach ($customers as $data) {
            $customer = Customer::create($data);

            // Przykładowe ustawienia rozliczeń (codziennie faktura dla testu)
            Settlement::create([
                'customer_id' => $customer->id,
                'billing_cycle' => 'daily',
                'next_billing_date' => now(),
                'billing_day1' => now()->day,
                'billing_day2' => now()->day,
                'monthly_billing_day' => now()->day,
                'weekly_billing_day' => strtolower(now()->englishDayOfWeek),
            ]);
        }
    }
}
