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
        Schema::create('pratiquedomaines', function (Blueprint $table) {
            $table->id();
            $table->Integer("pratique_id");
            $table->Integer("domaine_id");
            $table->timestamps();
            $table->unique(['pratique_id','domaine_id']);
            $table->foreign('pratique_id')->references('pratique_id')->on('pratiques');
            $table->foreign('domaine_id')->references('domaine_id')->on('domaines');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pratiquedomaines');
    }
};
