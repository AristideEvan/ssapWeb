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
        Schema::create('theme_domaine', function (Blueprint $table) {
            $table->id();
            $table->foreignId('theme_id')->constrained('themes', 'theme_id')->onDelete('cascade');
            // Spécifier la clé étrangère pour domaine_id
            $table->foreignId('domaine_id')->constrained('domaines', 'domaine_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_domaine');
    }
};
