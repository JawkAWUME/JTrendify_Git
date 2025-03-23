<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Clé primaire
            $table->unsignedBigInteger('user_id'); // Colonne pour la clé étrangère
            $table->unsignedBigInteger('order_id'); // Colonne pour la clé étrangère
            $table->decimal('amount', 8, 2); // Montant payé
            $table->string('status'); // Statut du paiement
            $table->timestamps(); // Les champs created_at et updated_at

            // Définir les contraintes de clé étrangère
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
