<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JadwalSiswa extends Model
{
    /**
     * @var string
     */
    protected $table = 'jadwalsiswa';

    /**
     * @var array
     */
    protected $fillable = [
        'hari', 'jam', 'ruang', 'mata_pelajaran', 'kelas', 'guru_pengampu', 
    ];
}