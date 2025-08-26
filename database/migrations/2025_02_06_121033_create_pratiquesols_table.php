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
        Schema::create('pratiquesols', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pratique_id');
            $table->unsignedBigInteger('sol_id');
            $table->timestamps();
            $table->foreign('pratique_id')->references('pratique_id')->on('pratiques')->onDelete('cascade');
            $table->foreign('sol_id')->references('sol_id')->on('sols')->onDelete('cascade');
            $table->unique(['pratique_id', 'sol_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pratiquesols');
    }
};
