<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('jurnal_id');
            $table->bigInteger('siswa_id');
            $table->text('materi')->nullable();
            $table->enum('kehadiran', ['H', 'I', 'A', 'S']);
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('jurnal_details');
    }
}
