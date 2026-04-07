<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('terrain_id');
            $table->date('reservation_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending');
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('terrain_id')->references('id')->on('terrains')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};