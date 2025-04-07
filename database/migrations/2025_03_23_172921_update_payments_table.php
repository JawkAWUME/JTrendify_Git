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
        Schema::table('payments', function (Blueprint $table) {
            // Ajouter des colonnes ou modifier la structure de la table
            $table->timestamps(); // Les champs created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Revert changes made in the 'up' method
            $table->dropForeign(['user_id']);
            $table->dropForeign(['order_id']);
            
            // Supprimer les colonnes ajoutées ou les modifications de structure
            // $table->dropColumn('new_column');
        });
    }
};
