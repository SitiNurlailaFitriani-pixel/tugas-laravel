<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SetorTunai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SetorTunaiController extends Controller
{
    public function index()
    {
        // Mengambil data pengguna yang sedang login untuk dikirim ke view
        $username = Auth::user()->name ?? Auth::user()->username ?? 'Admin';

        return view('admin.setor_tunai', compact('username'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'no_rekening'  => 'required|string',
            'jumlah_setor' => 'required|numeric|min:10000',
            'keterangan'   => 'nullable|string',
        ]);

        // 2. Simpan Data Setor Tunai
        SetorTunai::create([
            'no_rekening'  => trim($request->no_rekening),
            'jumlah_setor' => $request->jumlah_setor,
            'keterangan'   => $request->keterangan ?? 'Setor Tunai',
        ]);

        // 3. Tambahkan Saldo di Tabel 'users'
        DB::table('users')
            ->where('no_rekening', trim($request->no_rekening))
            ->increment('saldo', $request->jumlah_setor);

        // 4. Redirect Kembali ke Dashboard dengan Pesan Sukses
        return redirect()->route('admin.homeadmin')->with('success', 'Setor tunai berhasil! Saldo telah bertambah.');
    }
}