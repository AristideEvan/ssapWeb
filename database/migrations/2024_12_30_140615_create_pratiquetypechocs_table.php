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
        Schema::create('pratiquetypechocs', function (Blueprint $table) {
            $table->id();
            $table->Integer("pratique_id");
            $table->Integer("typeChoc_id");
            $table->timestamps();
            $table->unique(['pratique_id','typeChoc_id']);
            $table->foreign('pratique_id')->references('pratique_id')->on('pratiques');
            $table->foreign('typeChoc_id')->references('typeChoc_id')->on('type_chocs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pratiquetypechocs');
    }
};
