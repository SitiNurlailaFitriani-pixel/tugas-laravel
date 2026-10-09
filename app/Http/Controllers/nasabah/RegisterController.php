<?php

namespace App\Http\Controllers\nasabah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Menampilkan halaman register
    public function show()
    {
        return view('nasabah.register');
    }

    // Memproses data form registrasi
    public function store(Request $request)
    {
        // 1. Validasi Input (Ubah tabel register ke users)
        $request->validate([
            'nama_rekening' => 'required|string|max:100',
            'username'      => 'required|string|max:50|unique:users,username',
            'email'         => 'required|email|max:100|unique:users,email',
            'password'      => 'required|string|min:6',
        ], [
            'username.unique' => 'Username sudah digunakan!',
            'email.unique'    => 'Email sudah terdaftar!',
        ]);

        // 2. Generate Nomor Rekening Otomatis
        $noRekening = '777' . date('Ymd') . rand(1000, 9999);

        while (DB::table('users')->where('no_rekening', $noRekening)->exists()) {
            $noRekening = '777' . date('Ymd') . rand(1000, 9999);
        }

        // 3. Simpan Data ke Tabel 'users'
        $id = DB::table('users')->insertGetId([
            'no_rekening' => $noRekening,
            'name'        => $request->nama_rekening,
            'username'    => $request->username,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // 4. Set Session
        session([
            'is_login'      => true,
            'nasabah_id'    => $id,
            'nama_rekening' => $request->nama_rekening,
            'username'      => $request->username,
            'no_rekening'   => $noRekening,
        ]);

        session()->save();

        return redirect()->route('homenasabah')->with('success', 'Selamat datang! Akun berhasil dibuat.');
    }
}