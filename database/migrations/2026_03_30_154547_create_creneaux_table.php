<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creneaux', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('terrain_id');
            $table->string('day_of_week');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_available')->default(true);
            $table->timestamps();
            
            $table->foreign('terrain_id')->references('id')->on('terrains')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creneaux');
    }
};