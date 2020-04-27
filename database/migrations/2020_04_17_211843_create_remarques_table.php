<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemarquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remarques', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('projet_id')->unsigned();
            $table->foreign('projet_id')->references('id')->on('projets');
            $table->integer('type_remarque_id')->unsigned()->nullable();
            $table->foreign('type_remarque_id')->references('id')->on('type_remarques');
            $table->string('fichier');
            $table->string('demande_text');
            $table->softDeletes();
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
        Schema::dropIfExists('retours');
    }
}
