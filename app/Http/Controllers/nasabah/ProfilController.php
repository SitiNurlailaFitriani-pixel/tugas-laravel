<?php

namespace App\Http\Controllers\nasabah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfilController extends Controller
{
    public function index()
    {
        // Cek Session Login
        if (!session('is_login')) {
            return redirect()->route('login')->withErrors(['login_error' => 'Silakan login terlebih dahulu!']);
        }

        // Ambil Data Nasabah dari Database
        $nasabahId = session('nasabah_id');
        $username  = session('username');

        // Mengubah 'register' menjadi 'users'
        $nasabah = DB::table('users')
            ->where('id', $nasabahId)
            ->orWhere('username', $username)
            ->first();

        return view('nasabah.profil', compact('nasabah'));
    }
}