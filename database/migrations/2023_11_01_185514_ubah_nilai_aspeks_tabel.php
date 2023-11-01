<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UbahNilaiAspeksTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nilai_aspeks', function (Blueprint $table) {
            $table->renameColumn('nilai', 'nilai_p1');
            $table->dropColumn('deskripsi');
            $table->integer('nilai_p2')->after('nilai_p1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nilai_aspeks', function (Blueprint $table) {
            $table->renameColumn('nilai_p1', 'nilai');
            $table->text('deskripsi');
            $table->dropColumn('nilai_p2');
        });
    }
}
