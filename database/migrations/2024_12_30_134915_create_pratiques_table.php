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
        Schema::create('pratiques', function (Blueprint $table) {
            $table->id("pratique_id");
            $table->unsignedBigInteger("user_id");
            $table->string('pratiqueLibelle');
            $table->text('objectif');
            $table->bigInteger('periodeDebut');
            $table->bigInteger('periodeFin');
            $table->text('description');
            $table->text('conseil')->nullable();
            $table->text('avantage')->nullable();
            $table->text('contrainte')->nullable();
            $table->text('defis')->nullable();
            $table->boolean('vedette')->default(false);
            $table->boolean('publique')->default(false);
            $table->text('mesure')->nullable();
            $table->double('cout');
            $table->text('description_env_humain')->nullable();
            $table->text('recommandation')->nullable();
            $table->string('vedette_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->point('geom')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pratiques');
    }
};
