<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDudisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dudis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dudi');
            $table->string('alamat');
            $table->string('kec')->nullable();
            $table->string('kab_kota')->nullable();
            $table->string('prov')->nullable();
            $table->bigInteger('jurusan_id');
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
        Schema::dropIfExists('dudis');
    }
}
