<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    /**
     * Menampilkan riwayat transaksi seluruh nasabah untuk petugas.
     */
    public function index(Request $request)
    {
        // 1. Query Setor Tunai
        // Sesuaikan nama kolom status jika di database Anda bernama lain (misal: 'status')
        $setor = DB::table('setor_tunai')
            ->leftJoin('users', 'setor_tunai.no_rekening', '=', 'users.no_rekening')
            ->select(
                'setor_tunai.created_at',
                'setor_tunai.no_rekening',
                'users.username',
                'users.name as nama_lengkap',
                DB::raw("'Setor Tunai' as tipe"),
                'setor_tunai.jumlah_setor as nominal',
                'setor_tunai.status' // Pastikan kolom status ada di tabel setor_tunai
            );

        // 2. Query Tarik Tunai
        $tarik = DB::table('tarik_tunai')
            ->leftJoin('users', 'tarik_tunai.no_rekening', '=', 'users.no_rekening')
            ->select(
                'tarik_tunai.created_at',
                'tarik_tunai.no_rekening',
                'users.username',
                'users.name as nama_lengkap',
                DB::raw("'Tarik Tunai' as tipe"),
                'tarik_tunai.nominal',
                'tarik_tunai.status' // Pastikan kolom status ada di tabel tarik_tunai
            );

        // 3. Gabungkan kedua query (Union)
        $query = DB::query()->fromSub($tarik->unionAll($setor), 'combined_transaksi');

        // Filter Pencarian (No Rekening / Username / Nama Lengkap)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_rekening', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        // Filter Tanggal (Disamakan dengan name="tanggal" dari view)
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // Urutkan transaksi terbaru
        $riwayatData = $query->orderBy('created_at', 'desc')->get();

        // Split data per 5 baris
        $riwayatChunks = $riwayatData->chunk(5);

        // Kirim variabel $riwayatChunks ke view
        return view('petugas.riwayat', compact('riwayatChunks'));
    }
}