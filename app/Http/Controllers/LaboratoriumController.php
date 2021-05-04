<?php

namespace App\Http\Controllers;
use App\Laboratorium;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LaboratoriumController extends Controller
{
    public function index(Request $request)
    {
        $laboratorim = Laboratorium::when($request->q, function($laboratorim) use($request) {
            $laboratorim = $laboratorim->where('nama_alat', 'LIKE', '%' . $request->q . '%');
        })->paginate(10);

        return response()->json([
            'success' => true,
            'message' =>'List Semua Laboratorium',
            'data'    => $laboratorim
        ], 200);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_alat' => 'required|string|max:50',
            'jumlah' => 'required|string',
            'penanggung_jawab' => 'required|string',
            'status' => 'required',
        ]);
        
        Laboratorium::create([
            'nama_alat' => $request -> nama_alat,
            'jumlah' => $request -> jumlah,
            'penanggung_jawab' => $request -> penanggung_jawab,
            'status' => $request -> status,
            ]);
            return response()->json(['status' => 'success']);
    }
    public function edit($id)
    {
            //MENGAMBIL DATA BERDASARKAN ID
            $laboratorim = Laboratorium::find($id);
            //KEMUDIAN KIRIM DATANYA DALAM BENTUL JSON.
            return response()->json(['status' => 'success', 'data' => $laboratorim]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'judul' => 'required|string|max:50',
            'jumlah' => 'required|string',
            'penanggung_jawab' => 'required|string',
            'status' => 'required',
        ]);

        $laboratorim = Laboratorium::find($id); //GET DATA USER

        //KEMUDIAN PERBAHARUI DATA Laboratorium
        $laboratorim->update([
            'judul' => $request -> judul,
            'jumlah' => $request -> jumlah,
            'penanggung_jawab' => $request -> penanggung_jawab,
            'status' => $request -> status,
        ]);
        return response()->json(['status' => 'success']);
    }
    public function destroy($id)
    {
        $laboratorim = Laboratorium::find($id);
        $laboratorim->delete();
        return response()->json(['status' => 'success']);
    }

}