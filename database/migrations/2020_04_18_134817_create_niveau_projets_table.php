<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNiveauProjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('niveau_projets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('projet_id')->unsigned();
            $table->foreign('projet_id')->references('id')->on('projets');
            $table->integer('piece');
            $table->integer('chambre')->nullable();
            $table->integer('bureau')->nullable();
            $table->integer('salon')->nullable();
            $table->integer('cuisine')->nullable();
            $table->integer('toillette')->nullable();
            $table->string('fichier')->nullable();
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
        Schema::dropIfExists('niveau_projets');
    }
}
