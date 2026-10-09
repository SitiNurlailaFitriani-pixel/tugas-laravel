<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TarikTunaiController extends Controller
{
    // 1. Menampilkan Halaman Tarik Tunai Admin (Form Input + Tabel Pengajuan Nasabah)
    public function index()
    {
        // Ambil seluruh riwayat pengajuan tarik tunai beserta nama nasabah
        $tarikTunai = DB::table('tarik_tunai')
            ->leftJoin('users', 'tarik_tunai.no_rekening', '=', 'users.no_rekening')
            ->select(
                'tarik_tunai.*',
                'users.name as nama_nasabah'
            )
            ->orderBy('tarik_tunai.created_at', 'desc')
            ->get();

        return view('admin.tarik_tunai', compact('tarikTunai'));
    }

    // 2. Fungsi Menyetujui Pengajuan Tarik Tunai dari Nasabah
    public function setujui($id)
    {
        $tarik = DB::table('tarik_tunai')->where('id', $id)->first();

        if (!$tarik) {
            return redirect()->back()->with('error', 'Data pengajuan tidak ditemukan.');
        }

        if ($tarik->status !== 'Pending') {
            return redirect()->back()->with('error', 'Transaksi ini sudah diproses sebelumnya.');
        }

        // Ambil data nasabah berdasarkan no_rekening
        $nasabah = DB::table('users')->where('no_rekening', $tarik->no_rekening)->first();

        if (!$nasabah) {
            return redirect()->back()->with('error', 'Rekening nasabah tidak ditemukan.');
        }

        // Cek apakah saldo nasabah mencukupi
        if ($nasabah->saldo < $tarik->nominal) {
            return redirect()->back()->with('error', 'Saldo nasabah tidak mencukupi! (Saldo saat ini: Rp ' . number_format($nasabah->saldo, 0, ',', '.') . ')');
        }

        // Jalankan Transaksi Database: Potong Saldo & Ubah Status jadi Berhasil
        DB::transaction(function () use ($tarik) {
            // Potong Saldo Nasabah
            DB::table('users')
                ->where('no_rekening', $tarik->no_rekening)
                ->decrement('saldo', $tarik->nominal);

            // Ubah Status Pengajuan
            DB::table('tarik_tunai')
                ->where('id', $tarik->id)
                ->update([
                    'status' => 'Berhasil',
                    'updated_at' => now()
                ]);
        });

        return redirect()->back()->with('success', 'Pengajuan tarik tunai berhasil disetujui dan saldo nasabah telah dipotong.');
    }

    // 3. Fungsi Menolak Pengajuan Tarik Tunai dari Nasabah
    public function tolak($id)
    {
        $tarik = DB::table('tarik_tunai')->where('id', $id)->first();

        if ($tarik && $tarik->status === 'Pending') {
            DB::table('tarik_tunai')->where('id', $id)->update([
                'status' => 'Ditolak',
                'updated_at' => now()
            ]);

            return redirect()->back()->with('success', 'Pengajuan tarik tunai berhasil ditolak.');
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan atau sudah diproses.');
    }

    // 4. Fungsi Input Langsung oleh Admin (Jalur Teller / Kasir Langsung Berhasil)
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'no_rekening'      => 'required|string|exists:users,no_rekening',
            'jumlah_penarikan' => 'required|numeric|min:10000',
            'keterangan'       => 'nullable|string',
        ], [
            'no_rekening.required' => 'Nomor rekening wajib diisi.',
            'no_rekening.exists'   => 'Nomor rekening tidak terdaftar di database.',
            'jumlah_penarikan.min' => 'Minimal penarikan adalah Rp 10.000.',
        ]);

        $noRekening = trim($request->no_rekening);
        $jumlah = $request->jumlah_penarikan;

        // Ambil Data Nasabah
        $nasabah = DB::table('users')->where('no_rekening', $noRekening)->first();

        // Cek Saldo
        if ($nasabah->saldo < $jumlah) {
            return redirect()->back()->withInput()->withErrors([
                'jumlah_penarikan' => 'Saldo nasabah tidak mencukupi! (Saldo saat ini: Rp ' . number_format($nasabah->saldo, 0, ',', '.') . ')'
            ]);
        }

        // Potong Saldo & Catat ke Tabel tarik_tunai
        DB::transaction(function () use ($noRekening, $jumlah, $request) {
            // Potong Saldo
            DB::table('users')
                ->where('no_rekening', $noRekening)
                ->decrement('saldo', $jumlah);

            // Simpan Riwayat
            DB::table('tarik_tunai')->insert([
                'no_rekening' => $noRekening,
                'nominal'     => $jumlah,
                'keterangan'  => $request->keterangan ?? 'Tarik Tunai via Teller Admin',
                'status'      => 'Berhasil',
                'created_at'  => now(),
                'updated_at'  => now()
            ]);
        });

        return redirect()->route('admin.tarik_tunai.index')->with('success', 'Tarik tunai berhasil! Saldo nasabah telah dipotong.');
    }
}