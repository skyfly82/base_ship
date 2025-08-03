<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->decimal('amount_net', 10, 2)->default(0);
            $table->decimal('amount_vat', 10, 2)->default(0);
            $table->decimal('amount_gross', 10, 2)->default(0);
            $table->string('currency', 3)->default('PLN');
            $table->unsignedBigInteger('payment_method_id');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
