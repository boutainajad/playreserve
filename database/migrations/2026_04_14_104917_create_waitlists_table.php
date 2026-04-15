<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waitlists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('terrain_id');
            $table->date('reservation_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('status')->default('waiting');
            $table->timestamp('notified_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('terrain_id')->references('id')->on('terrains')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waitlists');
    }
};
