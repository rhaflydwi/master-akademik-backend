<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;



class NilaiSiswa extends Model
{
    /**
     * @var string
     */
    protected $table = 'nilai_siswa';

    /**
     * @var array
     */
    protected $fillable = [
        'id_user','name', 'kelas', 'mata_pelajaran', 'nilai',
    ];

    protected $appends = [
        'mata_pelajaran_teks',
        'kelas_teks',
        'nilai_teks',

    ];

    public function user_data()
    {
        return $this->belongsTo(User::class,'id_user');
        // return 'asd';

    }

    public function user_name_data()
    {
        return $this->belongsTo(User::class, 'name');
    }

    public function getMataPelajaranTeksAttribute()
    {

        $arr = [
            'Basis Data', 'Pemograman Web', 'Matematika', 'Bahasa Indonesia', 'Kimia', 'Fisika', 
        ];

        return $arr[$this->mata_pelajaran];
    }

    public function getKelasTeksAttribute()
    {

        $arr = [
            'VII', 'VIII', 'IX', 'Bukan Siswa'
        ];

        return $arr[$this->kelas];
    }

    public function getNilaiTeksAttribute()
    {

        $arr = [
            'A', 'B', 'C', 'D'
        ];

        return $arr[$this->nilai];
    }

}
