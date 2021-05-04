<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('nis_nip');
            $table->char('gender', 1)->comment('0: female, 1: male')->default(0);
            $table->string('address');
            $table->string('photo');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone_number');
            $table->integer('kelas')->comment('0: VII, 1: VIII 3: IX 4: bukan_siswa');
            $table->string('api_token', 40);
            $table->char('role', 1)->comment('0: admin, 1: guru, 2: siswa, 3: petugas_tata_usaha, 4: petugas_laboratorium, 5: petugas_perpustakaan, 6: kepala_sekolah');
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('users');
    }
}
