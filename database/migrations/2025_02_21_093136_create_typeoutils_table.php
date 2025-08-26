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
        Schema::create('typeoutils', function (Blueprint $table) {
            $table->id('typeoutil_id'); // Adding typeoutil_id as the primary key
            $table->string('typeoutilLibelle'); // Adding typeoutilLibelle as a string column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('typeoutils');
    }
};
