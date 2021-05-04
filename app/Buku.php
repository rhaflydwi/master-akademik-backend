<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    /**
     * @var string
     */
    protected $table = 'buku';

    /**
     * @var array
     */
    protected $fillable = [
        'judul', 'penerbit', 'penanggung_jawab', 'status', 
    ];
}