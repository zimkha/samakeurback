<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMontantToDeviseFinance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devise_finances', function (Blueprint $table) {
            $table->integer('montant')->nullable();
        });
        Schema::table('devise_estimes', function(Blueprint $table){
            $table->integer('montant')->nullable()->change();
  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devise_finances', function (Blueprint $table) {
            $table->dropColumn(['montant']);
        });
        Schema::table('devise_estimes', function (Blueprint $table) {
            $table->integer('montant')->change();
        });
    }
}
