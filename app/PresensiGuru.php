<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;



class PresensiGuru extends Model
{
    /**
     * @var string
     */
    protected $table = 'presensi_guru';

    /**
     * @var array
     */
    protected $fillable = [
        'id_user', 'kelas', 'status', 'mata_pelajaran', 
    ];

    protected $appends = [
        'mata_pelajaran_teks',
        'kelas_teks',
        'format_jam_masuk'

    ];

    public function user_data()
    {
        return $this->belongsTo(User::class,'id_user');

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

    public function getFormatJamMasukAttribute()
    {
        $format = Carbon::parse($this->jam_masuk)->format('H:s');
        return $format;
    }
}
