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
        Schema::create('pratiquesectacts', function (Blueprint $table) {
            $table->id();
            $table->Integer("pratique_id");
            $table->Integer("secteurActivite_id");
            $table->timestamps();
            $table->unique(['pratique_id','secteurActivite_id']);
            $table->foreign('pratique_id')->references('pratique_id')->on('pratiques');
            $table->foreign('secteurActivite_id')->references('secteurActivite_id')->on('secteur_activites');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pratiquesectacts');
    }
};
