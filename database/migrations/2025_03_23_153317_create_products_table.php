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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // La clé primaire de type auto-incrémenté
            $table->string('name'); // Le nom du produit
            $table->text('description'); // La description du produit
            $table->decimal('price', 8, 2); // Le prix avec 8 chiffres dont 2 après la virgule
            $table->integer('stock'); // Le stock du produit
            $table->unsignedBigInteger('category_id'); // La colonne pour la clé étrangère
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade'); // Clé étrangère pour la catégorie
            $table->timestamps(); // Les champs created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
