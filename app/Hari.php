<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hari extends Model
{
    /**
     * @var string
     */
    protected $table = 'jadwalsiswa';

    /**
     * @var array
     */
    protected $fillable = [
        'senin', 'selasa', 'rabu', 'kamis', 
    ];
}