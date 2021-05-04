<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalsiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwalsiswa', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('hari');
                $table->time('jam');
                $table->string('ruang');
                $table->string('mata_pelajaran');
                $table->string('kelas');
                $table->string('guru_pengampu');
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
        Schema::dropIfExists('jadwalsiswa');
    }
}
