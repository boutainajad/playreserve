<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('nom');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->string('telephone')->nullable();
        $table->boolean('is_banned')->default(false);
        $table->enum('role', ['super_admin', 'admin_club', 'client'])->default('client');
        $table->unsignedBigInteger('club_id')->nullable();
        $table->foreign('club_id')->references('id')->on('clubs')->onDelete('set null');
        $table->rememberToken();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
