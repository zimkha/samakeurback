<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsfalseToProjets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('niveau_projets', function (Blueprint $table) {
            $table->integer('piece')->nullable()->change();
            $table->string('niveau_name')->nullable()->change();
            $table->boolean('garage')->nullable();

        });
         Schema::table('niveau_plans', function (Blueprint $table) {
            $table->integer('piece')->nullable()->change();
            $table->string('niveau')->nullable()->change();
            $table->boolean('garage')->nullable();

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
            $table->integer('piece')->nullable(false)->change();
            $table->string('niveau_name')->nullable(false)->change();
            $table->dropColumn(['garage']);
        });
        Schema::table('niveau_plans', function (Blueprint $table) {
            $table->integer('piece')->nullable(false)->change();
            $table->string('niveau')->nullable(false)->change();
            $table->dropColumn(['garage']);

        });
    }
}
