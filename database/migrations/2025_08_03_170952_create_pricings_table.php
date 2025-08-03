<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pricings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('carrier_id');
            $table->decimal('price', 10, 2);
            $table->string('service_type');
            $table->string('currency', 3)->default('PLN');
            $table->timestamps();

            $table->foreign('carrier_id')->references('id')->on('carriers');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pricings');
    }
};
