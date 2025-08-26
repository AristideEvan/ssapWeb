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
        Schema::create('pratiqueparts', function (Blueprint $table) {
            $table->id();
            $table->Integer("pratique_id");
            $table->Integer("partenaire_id");
            $table->timestamps();
            $table->unique(['pratique_id','partenaire_id']);
            $table->foreign('pratique_id')->references('pratique_id')->on('pratiques');
            $table->foreign('partenaire_id')->references('partenaire_id')->on('partenaires');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pratiqueparts');
    }
};
