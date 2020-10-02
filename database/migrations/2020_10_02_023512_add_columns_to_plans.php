<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->integer('residence_location')->nullable();
            $table->integer('residence_personnel')->nullable();
            $table->integer('zone_assainie')->nullable();
            $table->integer('zone_electrifie')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['residence_location','residence_personnel','zone_assainie','zone_electrifie']);
        });
    }
}
