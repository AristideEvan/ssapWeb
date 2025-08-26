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
        Schema::create('pratiquezoneapplis', function (Blueprint $table) {
            $table->id();
            $table->Integer("pratique_id");
            $table->Integer("localite_id");
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->timestamps();
            $table->point('geom')->nullable();
            $table->unique(['pratique_id','localite_id']);
            $table->foreign('pratique_id')->references('pratique_id')->on('pratiques');
            $table->foreign('localite_id')->references('localite_id')->on('localites');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pratiquezoneapplis');
    }
};
