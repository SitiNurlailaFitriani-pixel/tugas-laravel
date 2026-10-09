<?php

namespace App\Http\Controllers\petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NasabahController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query mengambil data nasabah dari tabel users
        $query = DB::table('users');

        // Fitur Pencarian Nama atau Username
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Ambil data dengan pagination (5 data per halaman)
        $nasabah = $query->orderBy('id', 'desc')->paginate(5);

        return view('petugas.nasabah', compact('nasabah', 'search'));
    }

    public function destroy($id)
    {
        // Hapus data nasabah berdasarkan ID
        DB::table('users')->where('id', $id)->delete();

        return redirect()->route('petugas.nasabah')->with('success', 'Data nasabah berhasil dihapus');
    }
}