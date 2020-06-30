<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPaiements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paiements', function (Blueprint $table) {
            $table->string('payer_country')->nullable();
        });
        Schema::table('projets', function (Blueprint $table) {
            $table->integer('montant')->nullable();
        });
    }
   
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paiements', function (Blueprint $table) {
            $table->dropColumn(['payer_country']);
        });
      
            Schema::table('projets', function (Blueprint $table) {
                $table->dropColumn(['montant']);
            });
        
    }
}
