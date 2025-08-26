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
        Schema::create('outils', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('typeoutil_id');
            $table->string('titre');
            $table->string('image_path')->nullable();
            $table->text('contenu');
            $table->boolean('publique')->default(false);
            $table->timestamps();
            $table->foreign('typeoutil_id')->references('typeoutil_id')->on('typeoutils');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outils');
    }
};
