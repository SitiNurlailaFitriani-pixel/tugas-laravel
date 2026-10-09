<?php

namespace App\Http\Controllers\petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetorTunaiController extends Controller
{
    // Method untuk menampilkan halaman form setor tunai
    public function index()
    {
        return view('petugas.setor-tunai');
    }

    // Method untuk memproses transaksi setor tunai
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'no_rekening' => 'required',
            'jumlah'      => 'required|numeric|min:10000',
            'keterangan'  => 'nullable|string',
        ]);

        // 2. Cari data nasabah berdasarkan nomor rekening
        $nasabah = DB::table('users')->where('no_rekening', $request->no_rekening)->first();

        if (!$nasabah) {
            return redirect()->back()->with('error', 'Nomor rekening tidak ditemukan!')->withInput();
        }

        // 3. Tambahkan saldo ke rekening nasabah
        DB::table('users')
            ->where('no_rekening', $request->no_rekening)
            ->increment('saldo', $request->jumlah);

        // 4. Catat riwayat transaksi ke tabel setor_tunai
        DB::table('setor_tunai')->insert([
            'no_rekening' => $request->no_rekening,
            'jumlah_setor'     => $request->jumlah, // Sesuaikan dengan nama kolom nominal/jumlah di tabel setor_tunai kamu
            'keterangan'  => $request->keterangan ?? 'Setor Tunai',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->back()->with('success', 'Setor tunai berhasil! Saldo nasabah telah bertambah.');
    }
}