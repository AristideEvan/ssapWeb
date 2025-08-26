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
        Schema::create('partenaires', function (Blueprint $table) {
            $table->id('partenaire_id'); // Clé primaire
            $table->unsignedBigInteger('typePartenaire_id')->nullable(); // Clé étrangère facultative
            $table->string('nomPartenaire'); // Nom du partenaire obligatoire
            $table->string('sigle')->nullable(); // Sigle facultatif

            // Champs du répondant
            $table->string('nomRepondant')->nullable(); // Nom du répondant facultatif
            $table->string('prenomRepondant')->nullable(); // Prénom du répondant facultatif
            $table->string('telephoneRepondant')->nullable(); // Téléphone du répondant facultatif
            $table->string('emailRepondant')->nullable(); // Email du répondant facultatif

            $table->timestamps(); // Champs created_at et updated_at

            // Déclaration de la clé étrangère
            $table->foreign('typePartenaire_id')
                  ->references('typePartenaire_id')
                  ->on('type_partenaires')
                  ->onDelete('set null'); // Si le type de partenaire est supprimé, le champ devient NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partenaires');
    }
};
