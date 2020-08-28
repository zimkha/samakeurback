<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChantiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('plan_chantiers', function (Blueprint $table) {
        //     $table->increments('id');
           

        //     $table->timestamps();
        // });
        Schema::create('chantiers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fichier');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('etat')->default(0);    
            $table->timestamps();
        });
        Schema::create('devise_estimes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fichier');
            $table->boolean('etat')->default(false);
            $table->integer('chantier_id')->unsigned();
            $table->foreign('chantier_id')->references('id')->on('chantiers');
            $table->integer('montant');
            $table->timestamps();
        });
        Schema::create('contrat_executions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fichier');
            $table->integer('etat')->default(0); // Ni valide ni payé
            $table->integer('chantier_id')->unsigned();
            $table->foreign('chantier_id')->references('id')->on('chantiers');
            $table->timestamps();
        });
        Schema::create('devise_finance', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fichier');
            $table->boolean('etat')->default(false);
            $table->integer('chantier_id')->unsigned();
            $table->foreign('chantier_id')->references('id')->on('chantiers');
            $table->timestamps();
        });
        Schema::create('planning_previsionnels', function (Blueprint $table) {
            $table->id();
            $table->string('fichier');
            $table->integer('chantier_id')->unsigned();
            $table->foreign('chantier_id')->references('id')->on('chantiers');
            $table->timestamps();
        });
        Schema::create('planning_fonds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fichier');
            $table->integer('etat')->default(false);
            $table->integer('chantier_id')->unsigned();
            $table->foreign('chantier_id')->references('id')->on('chantiers');
            $table->timestamps();
        });

        Schema::create('payeds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('montant')->unsigned();           
            $table->integer('chantier_id')->unsigned();
            $table->string('etape')->nullable();
            $table->foreign('chantier_id')->references('id')->on('chantiers');
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
       
        Schema::dropIfExists('chantiers');
        Schema::dropIfExists('planning_fonds');
        Schema::dropIfExists('payeds');
        Schema::dropIfExists('devise_finance');
        Schema::dropIfExists('devise_estimes');
        Schema::dropIfExists('contrat_excustions');
        Schema::dropIfExists('planning_previsionnels');

    }
}
