<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laboratorium extends Model
{
    /**
     * @var string
     */
    protected $table = 'laboratorium';

    /**
     * @var array
     */
    protected $fillable = [
        'nama_alat', 'jumlah', 'penanggung_jawab', 'status', 
    ];
}