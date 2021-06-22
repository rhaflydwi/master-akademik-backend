<?php

namespace App\Http\Controllers;
use App\Buku;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $buku = Buku::when($request->q, function($buku) use($request) {
            $buku = $buku->where('judul', 'LIKE', '%' . $request->q . '%');
        })->paginate(10);
        
        return response()->json([
            'success' => true,
            'message' =>'List Semua buku',
            'data'    => $buku
        ], 200);
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