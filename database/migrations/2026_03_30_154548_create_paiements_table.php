<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_id');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');
            $table->string('transaction_id')->nullable();
            $table->string('payment_method')->default('card');
            $table->text('payment_details')->nullable();
            $table->timestamps();
            
            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};