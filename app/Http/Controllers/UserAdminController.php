<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    public function haha(Request $request)
    {
        $users = User::orderBy('created_at', 'desc')->where('role',"0")->when($request->q, function($users) use($request) {
            $users = $users->where('name', 'LIKE', '%' . $request->q . '%');
        })->paginate(10);
        return response()->json(['status' => 'success', 'data' => $users]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'nis_nip' => 'required|string|unique:users', //UNIQUE BERARTI DATA INI TIDAK BOLEH SAMA DI DALAM TABLE USERS
            'gender' => 'required',
            'address' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone_number' => 'required|string',
            'role' => 'required',
            'status' => 'required',
        ]);

        $filename = null;
        if ($request -> hasfile('photo')){
            $filename = Str::random(5) . $request->email . '.jpg';
            $file = $request->file('photo');
            $file -> move(base_path('public/images'), $filename);
        }
        
        User::create([
            'name' => $request -> name,
            'nis_nip' => $request -> nis_nip,
            'gender' => $request -> gender,
            'address' => $request -> address,
            'photo' => $filename,
            'email' => $request -> email,
            'password' => app('hash')->make($request->password),
            'phone_number' => $request -> phone_number,
            'role' => $request -> role,
            'status' => $request->status
            ]);
            return response()->json(['status' => 'success']);
    }
    public function edit($id)
    {
            //MENGAMBIL DATA BERDASARKAN ID
            $user = User::find($id);
            //KEMUDIAN KIRIM DATANYA DALAM BENTUL JSON.
            return response()->json(['status' => 'success', 'data' => $user]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'nis_nip' => 'required|string|unique:users,nis_nip,' . $id, //VALIDASI INI BERARTI ID YANG INGIN DIUPDATE AKAN DIKECUALIKAN UNTUK FILTER DATA UNIK
            'gender' => 'required',
            'address' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png', //MIMES BERARTI KITA HANYA MENGIZINKAN EXTENSION FILE YANG DISEBUTKAN
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'phone_number' => 'required|string',
            'role' => 'required',
            'status' => 'required',
        ]);

        $user = User::find($id); //GET DATA USER

        //JIKA PASSWORD YANG DIKIRIMKAN USER KOSONG, BERARTI DIA TIDAK INGIN MENGGANTI PASSWORD, MAKA KITA AKAN MENGAMBIL PASSWORD SAAT INI UNTUK DISIMPAN KEMBALI
        //JIKA TIDAK KOSONG, MAKA KITA ENCRYPT PASSWORD YANG BARU
        $password = $request->password != '' ? app('hash')->make($request->password):$user->password;

        //LOGIC YANG SAMA ADALAH DEFAULT DARI $FILENAME ADALAH NAMA FILE DARI DATABASE
        $filename = $user->photo;
        //JIKA ADA FILE GAMBAR YANG DIKIRIM
        if ($request->hasFile('photo')) {
            //MAKA KITA GENERATE NAMA DAN SIMPAN FILE BARU TERSEBUT
            $filename = Str::random(5) . $user->email . '.jpg';
            $file = $request->file('photo');
            $file->move(base_path('public/images'), $filename); //
            //HAPUS FILE LAMA
            unlink(base_path('public/images/' . $user->photo));
        }

        //KEMUDIAN PERBAHARUI DATA USERS
        $user->update([
            'name' => $request->name,
            'nis_nip' => $request->nis_nip,
            'gender' => $request->gender,
            'address' => $request->address,
            'photo' => $filename,
            'password' => $password,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'status' => $request->status
        ]);
        return response()->json(['status' => 'success']);
    }
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user->photo) {
            unlink(base_path('public/images/' . $user->photo));
        }
        $user->delete();
        return response()->json(['status' => 'success']);
    }

    public function login(Request $request)
    {
    //VALIDASI INPUTAN USER
    //DENGAN KETENTUAN EMAIL HARUS ADA DI TABLE USERS DAN PASSWORD MIN 6
    $this->validate($request, [
        'email' => 'required|email|exists:users,email',
        'password' => 'required|string|min:6'
        ]);

    //KITA CARI USER BERDASARKAN EMAIL
    $user = User::where('email', $request->email)->first();
    //JIK DATA USER ADA
    //KITA CHECK PASSWORD USER APAKAH SUDAH SESUAI ATAU BELUM
    //UNTUK MEMBANDINGKAN ENCRYPTED PASSWORD DENGAN PLAIN TEXT, KITA BISA MENGGUNAKAN FACADE CHECK
    if ($user && Hash::check($request->password, $user->password)) {
        $token = Str::random(40); //GENERATE TOKEN BARU
        $user->update(['api_token' => $token]); //UPDATE USER TERKAIT
        //DAN KEMBALIKAN TOKENNYA UNTUK DIGUNAKAN PADA CLIENT
        return response()->json(['status' => 'success', 'data' => $token]);
        }
    //JIKA TIDAK SESUAI, BERIKAN RESPONSE ERROR
    return response()->json(['status' => 'error']);
    }

    public function sendResetToken(Request $request)
    {
    //VALIDASI EMAIL UNTUK MEMASTIKAN BAHWA EMAILNYA SUDAH ADA
        $this->validate($request, [
        'email' => 'required|email|exists:users'
        ]);

    //GET DATA USER BERDASARKAN EMAIL TERSEBUT
        $user = User::where('email', $request->email)->first();
    //LALU GENERATE TOKENNYA
        $user->update(['reset_token' => Str::random(40)]);

    //kirim token via email sebagai otentikasi kepemilikan
        Mail::to($user->email)->send(new ResetPasswordMail($user));

        return response()->json(['status' => 'success', 'data' => $user->reset_token]);
    }

    public function verifyResetPassword(Request $request, $token)
    {
    //VALIDASI PASSWORD HARUS MIN 6 
        $this->validate($request, [
            'password' => 'required|string|min:6'
        ]);

    //CARI USER BERDASARKAN TOKEN YANG DITERIMA
        $user = User::where('reset_token', $token)->first();
    //JIKA DATANYA ADA
        if ($user) {
        //UPDATE PASSWORD USER TERKAIT
            $user->update(['password' => app('hash')->make($request->password)]);
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error']);
    }

    public function getUserLogin(Request $request)
    {
        return response()->json(['status' => 'success', 'data' => $request->user()]);
    }
    public function logout(Request $request)
    {
        $user = $request->user(); //GET USER YANG SEDANG LOGIN
        $user->update(['api_token' => null]); //UPDATE VALUENYA JADI NULL
        return response()->json(['status' => 'success']);
    }

}
