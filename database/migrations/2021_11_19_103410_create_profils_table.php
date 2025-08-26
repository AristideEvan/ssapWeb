<?php

use App\User\Profil;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProfilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->string('nomProfil');
            //$table->string('nomTypeProfil');
            //$table->text('actionProfil')->nullable();
            $table->unique('nomProfil');
            $table->timestamps();
        });

        DB::insert('INSERT INTO public.profils (id, "nomProfil", created_at, updated_at) VALUES (?, ?, ?, ?)',[1, 'Root', NULL, NULL]);
        DB::insert('INSERT INTO public.profils (id, "nomProfil", created_at, updated_at) VALUES (?, ?, ?, ?)',[2, 'Eleve', NULL, NULL]);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profils');
    }
}
