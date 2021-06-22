<?php
namespace App\Http\Controllers;
use App\NilaiSiswa;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class NilaiSiswaController extends Controller
{
    public function index($id, Request $request)
    {

        // if($id == undefined) {
        //     $id = $request
        // }
        $data = NilaiSiswa::where('id_user',$id)->with('user_data')->orderBy('created_at','ASC')->get();

        return response()->json([
            'success' => true,
            'message' =>'List Presensi'.    $id,
            'data'    => $data
        ], 200);
    }

    public function kelasvii(Request $request)
    {
        $nilaisiswa = NilaiSiswa::orderBy('created_at', 'desc')->where('kelas',"0")->when($request->q, function($nilaisiswa) use($request) {
            $nilaisiswa = $nilaisiswa->where('name', 'LIKE', '%' . $request->q . '%');
        })->paginate(10);
        return response()->json(['status' => 'success', 'data' => $nilaisiswa]);
    }

    public function kelasviii(Request $request)
    {
        $nilaisiswa = NilaiSiswa::orderBy('created_at', 'desc')->where('kelas',"1")->when($request->q, function($nilaisiswa) use($request) {
            $nilaisiswa = $nilaisiswa->where('name', 'LIKE', '%' . $request->q . '%');
        })->paginate(10);
        return response()->json(['status' => 'success', 'data' => $nilaisiswa]);
    }
    public function kelasxi(Request $request)
    {
        $nilaisiswa = NilaiSiswa::orderBy('created_at', 'desc')->where('kelas',"2")->when($request->q, function($nilaisiswa) use($request) {
            $nilaisiswa = $nilaisiswa->where('name', 'LIKE', '%' . $request->q . '%');
        })->paginate(10);
        return response()->json(['status' => 'success', 'data' => $nilaisiswa]);
    }

    public function store(Request $request)
    {
        Nilaisiswa::create([
            'id_user' => $request->id_user,
            'name' => $request->nama,
            'kelas' => $request->kelas,
            'mata_pelajaran' => $request->mata_pelajaran,
            'nilai' => $request->nilai_siswa

        ]);

        return response()->json([
            'success' => true,
            'message' => 'List Nilai Siswa', $request->all(),
            'data' => $request->id_user
        ]);
    }
    public function all(Request $request)
    {
        $nilaisiswa = NilaiSiswa::when($request->q, function($nilaisiswa) use($request) {
            $nilaisiswa = $nilaisiswa->where('name', 'LIKE', '%' . $request->q . '%');
        })->paginate(10);

        return response()->json([
            'success' => true,
            'message' =>'List Semua Nilai Siswa',
            'data'    => $nilaisiswa
        ], 200);
    }

    public function edit($id)
    {
            //MENGAMBIL DATA BERDASARKAN ID
            $nilaisiswa = NilaiSiswa::find($id);
            //KEMUDIAN KIRIM DATANYA DALAM BENTUL JSON.
            return response()->json(['status' => 'success', 'data' => $nilaisiswa]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:50',
            'kelas' => 'required|string|max:50',
            'mata_pelajaran' => 'required|string|max:50',
            'nilai_siswa' => 'required|string|max:50',
        ]);

        $nilaisiswa = NilaiSiswa::find($id); //GET DATA USER

        // $nilaisiswa = NilaiSiswa::where('id_user',$request->id_user); //GET DATA USER

        //KEMUDIAN PERBAHARUI DATA buku
        $nilaisiswa->update([
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'mata_pelajaran' => $request->mata_pelajaran,
            'nilai' => $request->nilai_siswa
        ]);
        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        $nilaisiswa = NilaiSiswa::where('id',$id); //GET DATA USER
        $nilaisiswa->delete();
        return response()->json(['status' => 'success']);
    }


}