<?php

namespace App\Http\Controllers;
use App\PresensiSiswa;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function index($id, Request $request)
    {

        // if($id == undefined) {
        //     $id = $request
        // }

        $data = PresensiSiswa::where('id_user',$id)->with('user_data')->orderBy('created_at','ASC')->get();

        return response()->json([
            'success' => true,
            'message' =>'List Presensi'.    $id,
            'data'    => $data
        ], 200);
    }
    public function all(Request $request)
    {
        $Presensi = PresensiSiswa::with('user_data')->when($request->q, function($Presensi) use($request) {
            $Presensi = $Presensi->where('user', 'LIKE', '%' . $request->q . '%');
        })->paginate(100);

        return response()->json([
            'success' => true,
            'message' =>'List Semua Laboratorium',
            'data'    => $Presensi
        ], 200);
    }
    public function absenMasuk(Request $request) {
        
        PresensiSiswa::create([
            'id_user' => $request->user()->id,
            // 'nama' => $request->user()->name,
            'kelas' => $request->user()->kelas,
            'status' => '0',
            'jam_masuk' => Carbon::now()->setTimeZone('Asia/Makassar'),
            'jam_pulang' => null,
            'mata_pelajaran' => $request->pelajaran
        ]);

        return response()->json([
            'success' => true,
            'message' => Carbon::now()->setTimezone('Asia/Makassar'),
            'data' => $request->user()->id
        ]);
    }
}