<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresensisiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presensisiswa', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('kelas')->comment('0: VII, 1: VIII 3: IX 4: bukan_siswa');
            $table->integer('status')->comment('0: Hadir, 1: Pulang');
            $table->char('mata_pelajaran', 1)->comment('0: Basis_Data, 1: Pemograman_Web, 2: Matematika, 3: Bahasa_Indonesia, 4: Kimia, 5: Fisika');
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
        Schema::dropIfExists('presensisiswa');
    }
}
