<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionmenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actionmenus', function (Blueprint $table) {
            $table->integer('menu_id');
            $table->integer('action_id');
            $table->id();
            //$table->integer('id')->nullable();
            $table->timestamps();
            $table->unique(['menu_id','action_id']);
            $table->foreign('menu_id')->references('id')->on('menus');
            $table->foreign('action_id')->references('id')->on('actions');
            //$table->primary(['menu_id','action_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actionmenus');
    }
}
