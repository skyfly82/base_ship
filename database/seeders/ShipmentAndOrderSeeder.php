<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Shipment;
use App\Models\Carrier;
use App\Models\PaymentMethod;

class ShipmentAndOrderSeeder extends Seeder
{
    public function run()
    {
        $customer = Customer::first();

        // Dodaj przewoźnika, jeśli brak
        $carrier = Carrier::first();
        if (!$carrier) {
            $carrier = Carrier::create([
                'name' => 'InPost',
                'api_code' => 'inpost'
            ]);
        }

        // Dodaj metodę płatności, jeśli brak
        $paymentMethod = PaymentMethod::first();
        if (!$paymentMethod) {
            $paymentMethod = PaymentMethod::create([
                'name' => 'Przelew',
                'code' => 'bank_transfer'
            ]);
        }

        for ($o=1; $o<=3; $o++) {
            $order = Order::create([
                'customer_id' => $customer->id,
                'amount_net' => 100 * $o,
                'amount_vat' => 23 * $o,
                'amount_gross' => 123 * $o,
                'currency' => 'PLN',
                'payment_method_id' => $paymentMethod->id,
            ]);

            for ($s=1; $s<=2; $s++) {
                Shipment::create([
                    'customer_id' => $customer->id,
                    'carrier_id' => $carrier->id,
                    'order_id' => $order->id,
                    'tracking_number' => 'TRK' . rand(100000,999999),
                    'status' => 'created',
                    'length_cm' => rand(20,80),
                    'width_cm' => rand(15,60),
                    'height_cm' => rand(10,40),
                    'weight_kg' => rand(1,20),
                    'billing_weight_kg' => rand(2,22),
                    'details' => json_encode(['info'=>'Test przesyłka '.($o*10+$s)]),
                ]);
            }
        }
    }
}
