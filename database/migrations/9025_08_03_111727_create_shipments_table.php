<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('carrier_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('status')->default('created');
            $table->decimal('length_cm', 6, 2)->nullable();
            $table->decimal('width_cm', 6, 2)->nullable();
            $table->decimal('height_cm', 6, 2)->nullable();
            $table->decimal('weight_kg', 8, 3)->nullable();
            $table->decimal('billing_weight_kg', 8, 3)->nullable();
            $table->json('details')->nullable();
            $table->unsignedBigInteger('system_user_id')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('carrier_id')->references('id')->on('carriers');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('system_user_id')->references('id')->on('system_users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipments');
    }
};
