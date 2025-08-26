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
        Schema::create('pratiquemedia', function (Blueprint $table) {
            $table->id("media_id");
            $table->String("chemin");
            $table->String("type");
            $table->String("nom_user");
            $table->Integer("pratique_id");
            $table->timestamps();
            $table->foreign('pratique_id')->references('pratique_id')->on('pratiques');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pratiquemedia');
    }
};
