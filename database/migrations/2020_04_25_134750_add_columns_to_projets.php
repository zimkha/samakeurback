<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProjets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->integer('superficie');
            $table->integer('longeur');          
            $table->integer('largeur');
            $table->boolean('acces_voirie');
            $table->boolean('electricite');
            $table->boolean('courant_faible');
            $table->boolean('assainissement');
            $table->boolean('eaux_pluvial');
            $table->boolean('bornes_visible');
            $table->boolean('necessite_bornage');
            $table->boolean('presence_mitoyen');
            $table->string('cadastre')->nullable();
            $table->string('geometre')->nullable();
            $table->string('etude_sol')->nullable();
            $table->string('autre')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->dropColumn([
                'superficie', 'longeur','largeur','acces_voirie','electricite','courant_faible',
                'assainissement', 'eaux_pluvial', 'bornes_visible', 'necessite_bornage', 'presence_mitoyen',
                'cadastre', 'geometre', 'etude_sol', 'autre'
            ]);
        });
    }
}
