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
        Schema::create('pratiquebenefs', function (Blueprint $table) {
            $table->id();
            $table->Integer("pratique_id");
            $table->Integer("beneficiaire_id");
            $table->timestamps();
            $table->unique(['pratique_id','beneficiaire_id']);
            $table->foreign('pratique_id')->references('pratique_id')->on('pratiques');
            $table->foreign('beneficiaire_id')->references('beneficiaire_id')->on('beneficiaires');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pratiquebenefs');
    }
};
