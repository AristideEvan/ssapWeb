<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sols', function (Blueprint $table) {
            $table->id('sol_id'); // Clé primaire personnalisée
            $table->string('solLibelle')->unique();
            $table->text('description')->nullable();
            $table->timestamps(); // Ajoute automatiquement `created_at` et `updated_at`
        });
    }

    public function down()
    {
        Schema::dropIfExists('sols');
    }
};
