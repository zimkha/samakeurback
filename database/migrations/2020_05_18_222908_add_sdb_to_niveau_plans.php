<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSdbToNiveauPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('niveau_plans', function (Blueprint $table) {
            $table->integer('sdb')->nullable();
        });
        Schema::table('niveau_projets', function (Blueprint $table) {
            $table->integer('sdb')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('niveau_plans', function (Blueprint $table) {
            $table->dropClolumn(['sdb']);
        });
        Schema::table('niveau_projets', function (Blueprint $table) {
            $table->dropClolumn(['sdb']);
        });
    }
}
