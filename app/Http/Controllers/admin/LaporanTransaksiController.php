<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanTransaksiController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil base query terfilter
        $transaksiQuery = $this->getFilteredQuery($request);

        // 2. Hitung Total Nominal Keseluruhan (sesuai filter aktif)
        $totalNominal = (clone $transaksiQuery)->sum('nominal');

        // 3. Paginasi data & pertahankan query string URL
        $transaksi = $transaksiQuery->orderBy('created_at', 'desc')
                                    ->paginate(10)
                                    ->withQueryString();

        return view('admin.laporan_transaksi', compact('transaksi', 'totalNominal'));
    }

    public function cetak(Request $request)
    {
        // 1. Jika tanggal kosong, otomatis tetapkan ke tanggal hari ini (Y-m-d)
        $tanggalInput = $request->filled('tanggal') ? $request->tanggal : date('Y-m-d');
        
        // Inject nilai tanggal ke request agar query filter ikut menyaring data per hari
        $request->merge(['tanggal' => $tanggalInput]);

        // 2. Ambil base query terfilter
        $transaksiQuery = $this->getFilteredQuery($request);

        // 3. Ambil semua data terfilter per hari tanpa paginasi
        $transaksi = $transaksiQuery->orderBy('created_at', 'desc')->get();
        $totalNominal = $transaksi->sum('nominal');

        return view('admin.cetaklaporan', compact('transaksi', 'totalNominal', 'tanggalInput'));
    }

    /**
     * Helper Method: Membangun Union Query & Filter Transaksi
     */
    private function getFilteredQuery(Request $request)
    {
        // Subquery 1: Setor Tunai
        $setor = DB::table('setor_tunai as s')
            ->leftJoin('users as u', 's.no_rekening', '=', 'u.no_rekening')
            ->select(
                's.id', 
                's.no_rekening', 
                DB::raw("COALESCE(u.username, u.name, '-') as username"), 
                's.jumlah_setor as nominal', 
                DB::raw("'Setor Tunai' as jenis_transaksi"), 
                DB::raw("COALESCE(s.status, 'berhasil') as status"),
                's.created_at'
            );

        // Subquery 2: Tarik Tunai
        $tarik = DB::table('tarik_tunai as t')
            ->leftJoin('users as u', 't.no_rekening', '=', 'u.no_rekening')
            ->select(
                't.id', 
                't.no_rekening', 
                DB::raw("COALESCE(u.username, u.name, '-') as username"), 
                't.nominal as nominal', 
                DB::raw("'Tarik Tunai' as jenis_transaksi"), 
                DB::raw("COALESCE(t.status, 'berhasil') as status"),
                't.created_at'
            );

        // Penggabungan UNION ALL
        $unionQuery = $setor->unionAll($tarik);

        // Bungkus Subquery
        $transaksiQuery = DB::table(DB::query()->fromSub($unionQuery, 'transaksi'));

        // =========================================================
        // FILTER KETAT: DIBUANG JIKA MENGANDUNG KATA DITOLAK / GAGAL
        // =========================================================
        $transaksiQuery->where(function ($q) {
            $q->where('status', 'not like', '%tolak%')
              ->where('status', 'not like', '%gagal%')
              ->where('status', 'not like', '%reject%')
              ->where('status', 'not like', '%cancel%');
        });

        // Filter Search (No. Rekening / Username)
        if ($request->filled('search')) {
            $search = $request->search;
            $transaksiQuery->where(function ($q) use ($search) {
                $q->where('no_rekening', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%');
            });
        }

        // Filter Jenis Transaksi
        if ($request->filled('jenis')) {
            $jenis = strtolower($request->jenis);
            if (in_array($jenis, ['setor tunai', 'setor', 'setor_tunai'])) {
                $transaksiQuery->where('jenis_transaksi', 'Setor Tunai');
            } elseif (in_array($jenis, ['tarik tunai', 'tarik', 'tarik_tunai'])) {
                $transaksiQuery->where('jenis_transaksi', 'Tarik Tunai');
            }
        }

        // Filter Tanggal
        if ($request->filled('tanggal')) {
            $transaksiQuery->whereDate('created_at', $request->tanggal);
        }

        return $transaksiQuery;
    }
}