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

    public function absenMasuk(Request $request) {



        PresensiSiswa::create([
            'id_user' => $request->user()->id,
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

    public function store(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required|string|max:50',
            'penerbit' => 'required|string',
            'penanggung_jawab' => 'required|string',
            'status' => 'required',
        ]);
        
        Buku::create([
            'judul' => $request -> judul,
            'penerbit' => $request -> penerbit,
            'penanggung_jawab' => $request -> penanggung_jawab,
            'status' => $request -> status,
            ]);
            return response()->json(['status' => 'success']);
    }
    public function edit($id)
    {
            //MENGAMBIL DATA BERDASARKAN ID
            $buku = Buku::find($id);
            //KEMUDIAN KIRIM DATANYA DALAM BENTUL JSON.
            return response()->json(['status' => 'success', 'data' => $buku]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'judul' => 'required|string|max:50',
            'penerbit' => 'required|string',
            'penanggung_jawab' => 'required|string',
            'status' => 'required',
        ]);

        $buku = Buku::find($id); //GET DATA USER

        //KEMUDIAN PERBAHARUI DATA buku
        $buku->update([
            'judul' => $request -> judul,
            'penerbit' => $request -> penerbit,
            'penanggung_jawab' => $request -> penanggung_jawab,
            'status' => $request -> status,
        ]);
        return response()->json(['status' => 'success']);
    }
    public function destroy($id)
    {
        $buku = Buku::find($id);
        $buku->delete();
        return response()->json(['status' => 'success']);
    }
    public function getBukuLogin(Request $request)
    {
        return response()->json(['status' => 'success', 'data' => $request->buku()]);
    }

}