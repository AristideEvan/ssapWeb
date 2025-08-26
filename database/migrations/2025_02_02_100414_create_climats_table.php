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
        Schema::create('climats', function (Blueprint $table) {
            $table->id('climat_id'); // Clé primaire personnalisée
            $table->string('libelleClimat')->unique();
            $table->text('description')->nullable();
            $table->timestamps(); // Ajoute created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('climats');
    }
};
