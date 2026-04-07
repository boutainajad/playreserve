<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('terrains', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sport_type');
            $table->text('description')->nullable();
            $table->decimal('price_per_hour', 10, 2);
            $table->boolean('is_available')->default(true);
            $table->unsignedBigInteger('club_id');
            $table->string('image')->nullable();
            $table->timestamps();
            
            $table->foreign('club_id')->references('id')->on('clubs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('terrains');
    }
};