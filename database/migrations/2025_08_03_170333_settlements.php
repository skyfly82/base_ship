<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->enum('billing_cycle', ['instant','daily','weekly','twice_monthly','monthly'])->default('monthly');
            $table->date('next_billing_date')->nullable();
            $table->unsignedTinyInteger('billing_day1')->nullable();
            $table->unsignedTinyInteger('billing_day2')->nullable();
            $table->unsignedTinyInteger('monthly_billing_day')->nullable();
            $table->enum('weekly_billing_day', ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'])->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    public function down()
    {
        Schema::dropIfExists('settlements');
    }
};
