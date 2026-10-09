<?php

namespace App\Http\Controllers\nasabah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        if (!session('is_login')) {
            return redirect()->route('login');
        }

        $noRekening = session('no_rekening');

        $user = DB::table('users')->where('no_rekening', $noRekening)->first();

        // Ambil riwayat setor tunai (termasuk kolom status)
        $setor = DB::table('setor_tunai')
            ->where('no_rekening', $noRekening)
            ->select('id', 'no_rekening', 'jumlah_setor as nominal', 'status', 'keterangan', 'created_at', DB::raw("'SETOR TUNAI' as tipe"))
            ->get();

        // Ambil riwayat tarik tunai (termasuk kolom status)
        $tarik = DB::table('tarik_tunai')
            ->where('no_rekening', $noRekening)
            ->select('id', 'no_rekening', 'nominal', 'status', 'keterangan', 'created_at', DB::raw("'TARIK TUNAI' as tipe"))
            ->get();

        $transaksiTerakhir = $setor->merge($tarik)->sortByDesc('created_at')->take(5);

        return view('nasabah.Homenasabah', [
            'saldo_anda'         => $user->saldo ?? 0,
            'transaksi_terakhir' => $transaksiTerakhir
        ]);
    }

    public function riwayat()
    {
        if (!session('is_login')) {
            return redirect()->route('login');
        }

        $noRekening = session('no_rekening');

        $setor = DB::table('setor_tunai')
            ->where('no_rekening', $noRekening)
            ->select('id', 'no_rekening', 'jumlah_setor as nominal', 'status', 'keterangan', 'created_at', DB::raw("'Setor Tunai' as tipe"))
            ->get();

        $tarik = DB::table('tarik_tunai')
            ->where('no_rekening', $noRekening)
            ->select('id', 'no_rekening', 'nominal', 'status', 'keterangan', 'created_at', DB::raw("'Tarik Tunai' as tipe"))
            ->get();

        $riwayat = $setor->merge($tarik)->sortByDesc('created_at');
        $riwayatChunks = $riwayat->chunk(5);

        return view('nasabah.riwayatnasabah', compact('riwayatChunks'));
    }

    public function laporan()
    {
        if (!session('is_login')) {
            return redirect()->route('login');
        }

        $noRekening = session('no_rekening');

        $user = DB::table('users')->where('no_rekening', $noRekening)->first();

        $setor = DB::table('setor_tunai')
            ->where('no_rekening', $noRekening)
            ->select('id', 'no_rekening', 'jumlah_setor as nominal', 'status', 'keterangan', 'created_at', DB::raw("'Setor Tunai' as tipe"))
            ->get();

        $tarik = DB::table('tarik_tunai')
            ->where('no_rekening', $noRekening)
            ->select('id', 'no_rekening', 'nominal', 'status', 'keterangan', 'created_at', DB::raw("'Tarik Tunai' as tipe"))
            ->get();

        $laporan = $setor->merge($tarik)->sortByDesc('created_at');

        return view('nasabah.laporan', [
            'user'    => $user,
            'laporan' => $laporan
        ]);
    }
}