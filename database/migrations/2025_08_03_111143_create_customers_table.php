<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->boolean('active')->default(true);

            // Dane adresowe
            $table->string('company_name')->nullable();
            $table->string('tax_id')->nullable();
            $table->enum('customer_type', ['b2c','b2b'])->default('b2c');

            $table->string('country')->default('PL');
            $table->string('city');
            $table->string('postal_code');
            $table->string('street');
            $table->string('building_number');
            $table->string('apartment_number')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
