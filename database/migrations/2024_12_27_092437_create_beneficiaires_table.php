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
        Schema::create('beneficiaires', function (Blueprint $table) {
            $table->id('beneficiaire_id'); // Clé primaire
            $table->string('beneficiaireLibelle'); // Libellé du bénéficiaire
            $table->unsignedBigInteger('typeBeneficiaire_id'); // Clé étrangère vers TypeBeneficiaire
            $table->timestamps();

            // Définir la clé étrangère
            $table->foreign('typeBeneficiaire_id')
                  ->references('typeBeneficiaire_id')
                  ->on('type_beneficiaires')
                  ->onDelete('set null'); // Suppression en cascade
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaires');
    }
};
