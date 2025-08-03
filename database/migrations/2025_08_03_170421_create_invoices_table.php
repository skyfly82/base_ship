<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('settlement_id')->nullable();
            $table->string('invoice_number')->unique();
            $table->date('issue_date');
            $table->date('billing_period_start')->nullable();
            $table->date('billing_period_end')->nullable();
            $table->decimal('amount_net', 10, 2);
            $table->decimal('amount_vat', 10, 2);
            $table->decimal('amount_gross', 10, 2);
            $table->string('currency', 3)->default('PLN');
            $table->json('details')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('settlement_id')->references('id')->on('settlements');
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
