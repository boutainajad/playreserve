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
    Schema::create('paiements', function (Blueprint $table) {
        $table->id();
        $table->foreignId('reservation_id')->constrained()->onDelete('cascade');
        $table->decimal('montant', 10, 2);
        $table->enum('mode', ['carte', 'paypal', 'virement']);
        $table->enum('statut', ['reussi', 'echoue', 'rembourse'])->default('reussi');
        $table->string('reference')->unique();
        $table->timestamp('paid_at')->useCurrent();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
