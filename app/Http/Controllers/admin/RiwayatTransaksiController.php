<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tanggal = $request->input('tanggal');

        // 1. Query Setor Tunai (Sertakan kolom 'status' atau 'status_transaksi')
        $setor = DB::table('setor_tunai')
            ->join('users', 'users.no_rekening', '=', 'setor_tunai.no_rekening')
            ->select(
                'setor_tunai.created_at as tanggal',
                'users.name as username',
                'setor_tunai.no_rekening',
                DB::raw("'Setor Tunai' as jenis"),
                'setor_tunai.jumlah_setor as jumlah',
                DB::raw("'+' as tipe"),
                'setor_tunai.status as status' // <-- DITAMBAHKAN (Sesuaikan dengan nama kolom di DB Anda, contoh: status / status_transaksi)
            );

        // 2. Query Tarik Tunai (Sertakan kolom 'status' atau 'status_transaksi')
        $tarik = DB::table('tarik_tunai')
            ->join('users', 'users.no_rekening', '=', 'tarik_tunai.no_rekening')
            ->select(
                'tarik_tunai.created_at as tanggal',
                'users.name as username',
                'tarik_tunai.no_rekening',
                DB::raw("'Tarik Tunai' as jenis"),
                'tarik_tunai.nominal as jumlah',
                DB::raw("'-' as tipe"),
                'tarik_tunai.status as status' // <-- DITAMBAHKAN
            );

        // 3. Gabungkan kedua query
        $query = $setor->unionAll($tarik);

        $transaksi = DB::query()->fromSub($query, 'semua_transaksi');

        if ($search) {
            $transaksi->where(function($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('no_rekening', 'like', "%{$search}%")
                  ->orWhere('jenis', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%"); // Opsional: Tambah pencarian via status
            });
        }

        if ($tanggal) {
            $transaksi->whereDate('tanggal', $tanggal);
        }

        // Paginasi 5 data per halaman
        $transaksi = $transaksi->orderBy('tanggal', 'desc')
                                ->paginate(5)
                                ->withQueryString();

        return view('admin.riwayat_transaksi', compact('transaksi', 'search', 'tanggal'));
    }
}