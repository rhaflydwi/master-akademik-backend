<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;



class PresensiSiswa extends Model
{
    /**
     * @var string
     */
    protected $table = 'presensisiswa';

    /**
     * @var array
     */
    protected $fillable = [
        'id_user','nama', 'kelas', 'status', 'mata_pelajaran', 
    ];

    protected $appends = [
        'mata_pelajaran_teks',
        'kelas_teks',
        'format_jam_masuk',
        'format_jam_pulang'

    ];

    public function user_data()
    {
        return $this->belongsTo(User::class,'id_user');
        // return 'asd';

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

    public function getFormatJamPulangAttribute()
    {
        if($this->jam_pulang != null)
        {
            $format = Carbon::parse($this->jam_pulang)->format('H:s');
        }else{
            $format = 'Belum Pulang';
        }
        return $format;
    }
}
