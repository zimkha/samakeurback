<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanProjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_projets', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('plan_id')->unsigned();
            $table->integer('projet_id')->unsigned();
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->foreign('projet_id')->references('id')->on('projets');
            $table->string('fichier');
            $table->boolean('active');
            $table->integer('etat_active');
            $table->string('message')->nullable();
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
        Schema::dropIfExists('plan_projets');
    }
}
