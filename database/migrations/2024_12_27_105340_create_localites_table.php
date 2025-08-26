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
        Schema::create('localites', function (Blueprint $table) {
            $table->id('localite_id');
            $table->unsignedBigInteger('typeLocalite_id'); // Clé étrangère vers TypeLocalite
            $table->unsignedBigInteger('parent_id')->nullable(); // Clé étrangère vers une autre localité (si applicable)
            $table->string('nomLocalite'); // Nom de la localité
            $table->string('codeAlpha2')->nullable(); // Code alpha 2
            $table->string('codeAlpha3')->nullable(); // Code alpha 3
            $table->integer('codeNum')->nullable(); // Code numérique
            $table->point('centroid')->nullable(); // Point géographique (type spatial)
            $table->timestamps();

            // Définir la contrainte de clé étrangère vers TypeLocalite
            $table->foreign('typeLocalite_id')->references('typeLocalite_id')->on('type_localites')->onDelete('cascade');

            // Définir la contrainte de clé étrangère vers la parent localité
            $table->foreign('parent_id')->references('localite_id')->on('localites')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('localites');
    }
};
