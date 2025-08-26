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
        Schema::create('pratiqueclimats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pratique_id');
            $table->unsignedBigInteger('climat_id');
            $table->timestamps();
            $table->foreign('pratique_id')->references('pratique_id')->on('pratiques')->onDelete('cascade');
            $table->foreign('climat_id')->references('climat_id')->on('climats')->onDelete('cascade');
            $table->unique(['pratique_id', 'climat_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pratiqueclimats');
    }
};
