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
        Schema::create('pratiquepiliers', function (Blueprint $table) {
            $table->id();
            $table->Integer("pratique_id");
            $table->Integer("pilier_id");
            $table->timestamps();
            $table->unique(['pratique_id','pilier_id']);
            $table->foreign('pratique_id')->references('pratique_id')->on('pratiques');
            $table->foreign('pilier_id')->references('pilier_id')->on('piliers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pratiquepiliers');
    }
};
