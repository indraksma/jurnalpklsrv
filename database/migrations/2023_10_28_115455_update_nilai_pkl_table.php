<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNilaiPklTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nilai_pkls', function (Blueprint $table) {
            $table->dropColumn('nilai');
            $table->dropColumn('catatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nilai_pkls', function (Blueprint $table) {
            $table->integer('nilai');
            $table->text('catatan')->nullable();
        });
    }
}
