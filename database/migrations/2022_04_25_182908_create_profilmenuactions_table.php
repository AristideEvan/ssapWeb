<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilmenuactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profilmenuactions', function (Blueprint $table) {
            $table->id();
            $table->integer('profil_id');
            $table->integer('menu_id');
            $table->integer('action_id');
            $table->unique(['profil_id','menu_id','action_id']);
            $table->foreign(['menu_id','action_id'])->references(['menu_id','action_id'])->on('actionmenus');
            $table->foreign('profil_id')->references('id')->on('profils');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profilmenuactions');
    }
}
