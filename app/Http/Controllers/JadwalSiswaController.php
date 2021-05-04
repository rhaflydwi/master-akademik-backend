<?php

namespace App\Http\Controllers;

use App\JadwalSiswa;
use App\Hari;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class JadwalSiswaController extends Controller
{
    public function index(Request $request)
    {       
        $jadwalsiswa = Jadwalsiswa::orderBy('hari', 'desc')->when($request->q, function($jadwalsiswa) use($request) {
            $jadwalsiswa = $jadwalsiswa->where('hari', 'LIKE', '%' . $request->q . '%');
        })->paginate(10);

        return response()->json([
            'success' => true,
            'message' =>'List Semua jadwa siswa',
            'data'    => $jadwalsiswa
        ], 200);
    }

        public function kelasvii(Request $request)
    {
        $jadwalsiswa = Jadwalsiswa::orderBy('created_at', 'desc')->where('kelas',"VII")->when($request->q, function($jadwalsiswa) use($request) {
            $jadwalsiswa = $jadwalsiswa->where('name', 'LIKE', '%' . $request->q . '%');
        })->paginate(10);
        return response()->json(['status' => 'success', 'data' => $jadwalsiswa]);
    }

    public function kelasviii(Request $request)
    {
        $jadwalsiswa = Jadwalsiswa::orderBy('created_at', 'desc')->where('kelas',"VIII")->when($request->q, function($jadwalsiswa) use($request) {
            $jadwalsiswa = $jadwalsiswa->where('name', 'LIKE', '%' . $request->q . '%');
        })->paginate(10);
        return response()->json(['status' => 'success', 'data' => $jadwalsiswa]);
    }
    public function kelasix(Request $request)
    {
        $jadwalsiswa = Jadwalsiswa::orderBy('created_at', 'desc')->where('kelas',"IX")->when($request->q, function($jadwalsiswa) use($request) {
            $jadwalsiswa = $jadwalsiswa->where('name', 'LIKE', '%' . $request->q . '%');
        })->paginate(10);
        return response()->json(['status' => 'success', 'data' => $jadwalsiswa]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hari' => 'required',
            'jam' => 'required',
            'ruang' => 'required',
            'mata_pelajaran' => 'required',
            'kelas' => 'required',
            'guru_pengampu' => 'required',
        ]);

        if ($validator->fails()){

            return response()->json([
                'success' => false,
                'message' => 'Semua Kolom Wajib Diisi!',
                'data'    => $validator->errors()
            ],401);
        } else{

            $jadwalsiswa = JadwalSiswa::create([
                'hari' => $request->input('hari'),
                'jam' => $request->input('jam'),
                'ruang' => $request->input('ruang'),
                'mata_pelajaran' => $request->input('mata_pelajaran'),
                'kelas' => $request->input('kelas'),
                'guru_pengampu' => $request->input('guru_pengampu'),
            ]);

            if ($jadwalsiswa) {
                return response()->json([
                    'success' => true,
                    'message' => 'jadwalsiswa Berhasil Disimpan!',
                    'data'    => $jadwalsiswa
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'jadwal siswa Gagal Disimpan!',
                ], 400);
            }

        }
    }
    public function edit($id)
    {
            //MENGAMBIL DATA BERDASARKAN ID
            $jadwalsiswa = Jadwalsiswa::find($id);
            //KEMUDIAN KIRIM DATANYA DALAM BENTUL JSON.
            return response()->json(['status' => 'success', 'data' => $jadwalsiswa]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'hari' => 'required|string|max:50',
            'jam' => 'required|string|max:50',
            'ruang' => 'required|string|max:10',
            'mata_pelajaran' => 'required|string|max:50',
            'kelas' => 'required|string|max:50',
            'guru_pengampu' => 'required|string|max:50',
        ]);

        $jadwalsiswa = Jadwalsiswa::find($id); //GET DATA USER

        //KEMUDIAN PERBAHARUI DATA buku
        $jadwalsiswa->update([
            'hari' => $request -> hari,
            'jam' => $request -> jam,
            'ruang' => $request -> ruang,
            'mata_pelajaran' => $request -> mata_pelajaran,
            'kelas' => $request -> kelas,
            'guru_pengampu' => $request -> guru_pengampu
        ]);
        return response()->json(['status' => 'success']);
    }
    public function destroy($id)
    {
        $jadwalsiswa = Jadwalsiswa::find($id);
        $jadwalsiswa->delete();
        return response()->json(['status' => 'success']);
    }
}
