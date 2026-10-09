<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeAdminController extends Controller
{
    public function index()
    {
        // 1. Hitung total Nasabah & Petugas
        $totalNasabah = User::where('role', 'nasabah')->count(); 
        $totalPetugas = User::where('role', 'petugas')->count();
        
        // 2. Hitung total Rekening unik
        $rekeningSetor = DB::table('setor_tunai')->select('no_rekening');
        $rekeningTarik = DB::table('tarik_tunai')->select('no_rekening');
        $totalRekening = $rekeningSetor->union($rekeningTarik)->get()->count();

        // 3. Ambil data Setor Tunai hari ini (Hardcode status 'Berhasil', tidak panggil kolom status)
        $setorHariIni = DB::table('setor_tunai')
            ->select(
                'created_at',
                DB::raw("'Setor Tunai' as jenis"),
                'jumlah_setor as jumlah',
                DB::raw("'Berhasil' as status")
            )
            ->whereDate('created_at', Carbon::today());

        // 4. Ambil data Tarik Tunai hari ini
        $tarikHariIni = DB::table('tarik_tunai')
            ->select(
                'created_at',
                DB::raw("'Tarik Tunai' as jenis"),
                'nominal as jumlah',
                DB::raw("COALESCE(status, 'Pending') as status")
            )
            ->whereDate('created_at', Carbon::today());

        // 5. Gabungkan transaksi hari ini & urutkan
        $transaksiHariIni = $setorHariIni->unionAll($tarikHariIni)
            ->orderBy('created_at', 'desc')
            ->get();

        // 6. Total seluruh transaksi
        $totalTransaksi = DB::table('setor_tunai')->count() + DB::table('tarik_tunai')->count();

        // ==========================================
        // 7. FITUR NOTIFIKASI PENDING (Khusus Tarik Tunai)
        // ==========================================
        
        $notifikasiPending = DB::table('tarik_tunai')
            ->join('users', 'tarik_tunai.no_rekening', '=', 'users.no_rekening')
            ->select(
                'tarik_tunai.id',
                'users.name as nama_nasabah',
                'tarik_tunai.no_rekening',
                'tarik_tunai.nominal as jumlah',
                'tarik_tunai.keterangan',
                'tarik_tunai.created_at',
                DB::raw("'Tarik Tunai' as jenis")
            )
            ->where('tarik_tunai.status', 'Pending')
            ->orderBy('tarik_tunai.created_at', 'desc')
            ->get();

        // Jumlah badge notifikasi
        $totalPendingCount = $notifikasiPending->count();

        return view('admin.homeadmin', compact(
            'totalNasabah',
            'totalRekening',
            'totalTransaksi',
            'transaksiHariIni',
            'notifikasiPending',
            'totalPendingCount'
        ));
    }
}