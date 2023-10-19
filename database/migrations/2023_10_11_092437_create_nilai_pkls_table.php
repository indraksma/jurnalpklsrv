<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiPklsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_pkls', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tahun_ajaran_id');
            $table->bigInteger('siswa_id');
            $table->bigInteger('kelas_id');
            $table->bigInteger('dudi_id');
            $table->integer('nilai');
            $table->text('catatan')->nullable();
            $table->bigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilai_pkls');
    }
}
