<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CustomerAndSettlementSeeder::class,
            ShipmentAndOrderSeeder::class,
        ]);
    }
}
