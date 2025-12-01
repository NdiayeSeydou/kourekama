<?php
// database/migrations/2024_09_28_000000_create_stocks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('nom_produit');
            $table->integer('quantite_entree')->default(0);
            $table->integer('quantite_sortie')->default(0);
            $table->decimal('prix_unitaire', 10, 2)->default(0);
            $table->decimal('prix_total', 10, 2)->default(0);
            $table->integer('alerte_stock')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
