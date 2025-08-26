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
        Schema::create('pratiquereponses', function (Blueprint $table) {
            $table->id();
            $table->Integer("pratique_id");
            $table->Integer("typeReponse_id");
            $table->timestamps();
            $table->unique(['pratique_id','typeReponse_id']);
            $table->foreign('pratique_id')->references('pratique_id')->on('pratiques');
            $table->foreign('typeReponse_id')->references('typeReponse_id')->on('type_reponses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pratiquereponses');
    }
};
