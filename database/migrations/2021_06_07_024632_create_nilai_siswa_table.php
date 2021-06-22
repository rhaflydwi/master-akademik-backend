<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_siswa', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('name');
            $table->integer('kelas')->comment('0: VII, 1: VIII 3: IX 4: bukan_siswa');
            $table->char('mata_pelajaran', 1)->comment('0: Basis_Data, 1: Pemograman_Web, 2: Matematika, 3: Bahasa_Indonesia, 4: Kimia, 5: Fisika');
            $table->integer('nilai')->comment('0: A, 1: B 3: C 4: D');
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
        Schema::dropIfExists('nilai_siswa');
    }
}
