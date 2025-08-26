<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilmenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profilmenus', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_id');
            $table->integer('profil_id'); //id de profil qui vient d'être créé
            $table->unique(['menu_id','profil_id']);
            
            $table->foreign('menu_id')->references('id')->on('menus');
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
        Schema::dropIfExists('profilmenus');
    }
}
