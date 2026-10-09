<?php

namespace App\Http\Controllers\nasabah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class RiwayatNasabahController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil nomor rekening dari session login
        $noRekening = session('no_rekening');

        if (!$noRekening) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Ambil data Setor Tunai
        // Kerena tabel setor_tunai tidak punya kolom status, hardcode langsung ke 'Berhasil'
        $setor = DB::table('setor_tunai')
            ->select(
                'id',
                'no_rekening',
                'jumlah_setor as nominal',
                'keterangan',
                DB::raw("'Berhasil' as status"), // <--- DIUBAH DI SINI (tanpa memanggil COALESCE(status, ...))
                DB::raw("'Setor Tunai' as jenis_transaksi"),
                'created_at'
            )
            ->where('no_rekening', $noRekening)
            ->get();

        // 3. Ambil data Tarik Tunai
        // Gunakan COALESCE untuk tarik_tunai jika kolom status ada, atau ganti jika nama kolom status di tarik_tunai berbeda
        $tarik = DB::table('tarik_tunai')
            ->select(
                'id',
                'no_rekening',
                'nominal',
                'keterangan',
                DB::raw("COALESCE(status, 'Pending') as status"), // Membaca kolom status dari tabel tarik_tunai
                DB::raw("'Tarik Tunai' as jenis_transaksi"),
                'created_at'
            )
            ->where('no_rekening', $noRekening)
            ->get();

        // 4. Gabungkan kedua data (Collection Merge)
        $transaksiAll = $setor->concat($tarik);

        // --- FILTER 1: TANGGAL ---
        if ($request->filled('tanggal')) {
            $tgl = $request->tanggal;
            $transaksiAll = $transaksiAll->filter(function ($item) use ($tgl) {
                return Carbon::parse($item->created_at)->format('Y-m-d') === $tgl;
            });
        }

        // --- FILTER 2: SEARCH ---
        if ($request->filled('search')) {
            $keyword = strtolower($request->search);
            
            $transaksiAll = $transaksiAll->filter(function ($item) use ($keyword) {
                $formattedDate = strtolower(Carbon::parse($item->created_at)->format('d M Y, H:i'));

                return str_contains(strtolower($item->jenis_transaksi ?? ''), $keyword) ||
                       str_contains(strtolower($item->no_rekening ?? ''), $keyword) ||
                       str_contains((string) $item->nominal, $keyword) ||
                       str_contains(strtolower($item->keterangan ?? ''), $keyword) ||
                       str_contains(strtolower($item->status ?? ''), $keyword) ||
                       str_contains($formattedDate, $keyword);
            });
        }

        // Urutkan dari tanggal transaksi terbaru
        $transaksiAll = $transaksiAll->sortByDesc('created_at')->values();

        // 5. Buat Manual Pagination (5 data per halaman)
        $perPage = 5; 
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $transaksiAll->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $transaksi = new LengthAwarePaginator(
            $currentPageItems,
            $transaksiAll->count(),
            $perPage,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query()
            ]
        );

        return view('nasabah.riwayatnasabah', compact('transaksi'));
    }
}