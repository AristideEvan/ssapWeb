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
        Schema::create('pratiquethemes', function (Blueprint $table) {
            $table->id();
            $table->Integer("pratique_id");
            $table->Integer("theme_id");
            $table->unique(['pratique_id','theme_id']);
            $table->foreign('pratique_id')->references('pratique_id')->on('pratiques');
            $table->foreign('theme_id')->references('theme_id')->on('themes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pratiquethemes');
    }
};
