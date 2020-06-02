<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToJoinedsColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('joineds', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('projets', function (Blueprint $table) {
            $table->string('name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('joineds', function (Blueprint $table) {
            $table->dropColumn(['deleted_at']);
        });
        Schema::table('projets', function (Blueprint $table) {
            $table->dropColumn(['name']);
        });
    }
}
