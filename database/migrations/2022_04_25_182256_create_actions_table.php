<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->string('nomAction');
            $table->unique('nomAction');
            $table->timestamps();
        });

        DB::insert('INSERT INTO public.actions ("nomAction", created_at, updated_at) VALUES (?, ?, ?)',['Créer', NULL, NULL]);
        DB::insert('INSERT INTO public.actions ("nomAction", created_at, updated_at) VALUES (?, ?, ?)',['Modifier', NULL, NULL]);
        DB::insert('INSERT INTO public.actions ("nomAction", created_at, updated_at) VALUES (?, ?, ?)',['Supprimer', NULL, NULL]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actions');
    }
}
