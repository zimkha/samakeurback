<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdatecolumnToRemarques extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('remarques', function (Blueprint $table) {
            $table->unsignedInteger('type_remarque_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('remarques', function (Blueprint $table) {
            $table->unsignedInteger('type_remarque_id')->nullable(false)->change();
        });
    }
}
