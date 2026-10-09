<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DataNasabahController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $nasabah = User::when($search, function ($query, $keyword) {
            return $query->where('name', 'like', "%{$keyword}%")
                         ->orWhere('username', 'like', "%{$keyword}%");
        })->paginate(10);

        return view('admin.datanasabah', compact('nasabah', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // 1. Buat user dummy dulu untuk mendapatkan ID terakhir
        $user = User::create([
            'name' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'nasabah',
            'saldo' => 0,
        ]);

        // 2. Buat nomor rekening otomatis sesuai format (awalan 777 + Tahun + ID User)
        $noRekening = '777' . date('Y') . str_pad($user->id, 7, '0', STR_PAD_LEFT);

        // 3. Update nomor rekening ke user yang baru saja dibuat
        $user->update([
            'no_rekening' => $noRekening
        ]);

        return redirect()->route('admin.nasabah.index')->with('success', 'Nasabah dan nomor rekening berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        // Karena nomor rekening dan saldo ada di tabel users, cukup hapus data user-nya saja
        // maka otomatis nomor rekening & saldonya ikut terhapus dari tabel users.
        $nasabah = User::findOrFail($id);
        $nasabah->delete();

        return redirect()->route('admin.nasabah.index')->with('success', 'Data nasabah dan rekeningnya berhasil dihapus!');
    }
}