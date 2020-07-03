<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGarageToProjets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->boolean('garage')->nullable();
        });
        Schema::table('plans', function (Blueprint $table) {
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
            $table->dropColumn(['garage']);
        });
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['garage']);
        });
    }
}
