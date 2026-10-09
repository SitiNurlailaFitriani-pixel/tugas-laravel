<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PetugasDashboardController extends Controller
{
    public function index()
    {
        $totalNasabah = DB::table('users')->count();

        $today = Carbon::today();
        $setorHariIni = DB::table('setor_tunai')->whereDate('created_at', $today)->count();
        $tarikHariIni = DB::table('tarik_tunai')->whereDate('created_at', $today)->count();
        $transaksiHariIni = $setorHariIni + $tarikHariIni;

        $pendingList = DB::table('tarik_tunai')
            ->join('users', 'tarik_tunai.no_rekening', '=', 'users.no_rekening')
            ->where('tarik_tunai.status', 'pending')
            ->select(
                'tarik_tunai.id',
                'tarik_tunai.nominal',
                'tarik_tunai.no_rekening as rekening',
                'tarik_tunai.created_at',
                'users.name as nama'
            )
            ->orderBy('tarik_tunai.created_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->jenis = 'Tarik Tunai';
                $item->waktu = Carbon::parse($item->created_at)->diffForHumans();
                return $item;
            });

        $pendingCount = $pendingList->count();

        return view('petugas.home', compact('totalNasabah', 'transaksiHariIni', 'pendingList', 'pendingCount'));
    }

    public function setujui($id)
    {
        $transaksi = DB::table('tarik_tunai')->where('id', $id)->first();

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Data transaksi tidak ditemukan.');
        }

        // Jalankan Database Transaction agar saldo & status terupdate bersamaan
        DB::transaction(function () use ($transaksi, $id) {
            // 1. Update status transaksi menjadi 'disetujui'
            DB::table('tarik_tunai')->where('id', $id)->update([
                'status' => 'disetujui',
                'updated_at' => now()
            ]);

            // 2. Potong Saldo Nasabah di tabel users
            DB::table('users')
                ->where('no_rekening', $transaksi->no_rekening)
                ->decrement('saldo', $transaksi->nominal);

            // 3. Simpan Notifikasi untuk Admin & Nasabah
            DB::table('notifications')->insert([
                [
                    'role_tujuan' => 'admin',
                    'no_rekening' => null,
                    'judul'       => 'Persetujuan Transaksi',
                    'pesan'       => 'Petugas menyetujui penarikan sebesar Rp ' . number_format($transaksi->nominal, 0, ',', '.') . ' (Rek: ' . $transaksi->no_rekening . ')',
                    'is_read'     => false,
                    'created_at'  => now(),
                    'updated_at'  => now()
                ],
                [
                    'role_tujuan' => 'nasabah',
                    'no_rekening' => $transaksi->no_rekening,
                    'judul'       => 'Penarikan Disetujui',
                    'pesan'       => 'Pengajuan tarik tunai berhasil disetujui dan saldo Anda telah dipotong.',
                    'is_read'     => false,
                    'created_at'  => now(),
                    'updated_at'  => now()
                ]
            ]);
        });

        return redirect()->back()->with('success', 'Pengajuan tarik tunai berhasil disetujui dan saldo nasabah telah dipotong.');
    }

    public function tolak($id)
    {
        $transaksi = DB::table('tarik_tunai')->where('id', $id)->first();

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Data transaksi tidak ditemukan.');
        }

        DB::transaction(function () use ($transaksi, $id) {
            // 1. Update status transaksi menjadi 'ditolak'
            DB::table('tarik_tunai')->where('id', $id)->update([
                'status' => 'ditolak',
                'updated_at' => now()
            ]);

            // 2. Simpan Notifikasi untuk Admin & Nasabah
            DB::table('notifications')->insert([
                [
                    'role_tujuan' => 'admin',
                    'no_rekening' => null,
                    'judul'       => 'Penolakan Transaksi',
                    'pesan'       => 'Petugas menolak penarikan sebesar Rp ' . number_format($transaksi->nominal, 0, ',', '.') . ' (Rek: ' . $transaksi->no_rekening . ')',
                    'is_read'     => false,
                    'created_at'  => now(),
                    'updated_at'  => now()
                ],
                [
                    'role_tujuan' => 'nasabah',
                    'no_rekening' => $transaksi->no_rekening,
                    'judul'       => 'Penarikan Ditolak',
                    'pesan'       => 'Pengajuan tarik tunai sebesar Rp ' . number_format($transaksi->nominal, 0, ',', '.') . ' telah ditolak.',
                    'is_read'     => false,
                    'created_at'  => now(),
                    'updated_at'  => now()
                ]
            ]);
        });

        return redirect()->back()->with('error', 'Pengajuan tarik tunai telah ditolak.');
    }
}