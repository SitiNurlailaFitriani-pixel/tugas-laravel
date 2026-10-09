<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TarikTunaiController extends Controller
{
    // Menampilkan halaman form Tarik Tunai
    public function index()
    {
        return view('petugas.tarik-tunai');
    }

    // Memproses penarikan tunai langsung dari form petugas
    public function store(Request $request)
    {
        $request->validate([
            'no_rekening' => 'required',
            'jumlah'      => 'required|numeric|min:10000',
            'keterangan'  => 'nullable|string',
        ]);

        $nasabah = DB::table('users')->where('no_rekening', $request->no_rekening)->first();

        if (!$nasabah) {
            return redirect()->back()->with('error', 'Nomor rekening tidak ditemukan!')->withInput();
        }

        if ($nasabah->saldo < $request->jumlah) {
            return redirect()->back()->with('error', 'Saldo nasabah tidak mencukupi!')->withInput();
        }

        DB::transaction(function () use ($request, $nasabah) {
            // Potong saldo
            DB::table('users')
                ->where('no_rekening', $request->no_rekening)
                ->decrement('saldo', $request->jumlah);

            // Payload fleksibel untuk tabel tarik_tunai
            $dataTarikTunai = [
                'user_id'     => $nasabah->id ?? null,
                'rekening'    => $request->no_rekening,
                'no_rekening' => $request->no_rekening,
                'nominal'     => $request->jumlah,
                'jumlah'      => $request->jumlah,
                'keterangan'  => $request->keterangan ?? 'Tarik Tunai Direct',
                'status'      => 'Berhasil',
                'created_at'  => now(),
                'updated_at'  => now(),
            ];

            // Filter kolom agar hanya memasukkan kolom yang ada di tabel tarik_tunai
            $tarikColumns = Schema::getColumnListing('tarik_tunai');
            $insertTarik = array_intersect_key($dataTarikTunai, array_flip($tarikColumns));
            DB::table('tarik_tunai')->insert($insertTarik);

            // Payload fleksibel untuk tabel transaksi
            $dataTransaksi = [
                'kode_transaksi'  => 'TRX-' . time() . rand(100, 999),
                'user_id'         => $nasabah->id ?? null,
                'rekening'        => $request->no_rekening,
                'no_rekening'     => $request->no_rekening,
                'jenis'           => 'Tarik Tunai',
                'jenis_transaksi' => 'Tarik Tunai',
                'nominal'         => $request->jumlah,
                'keterangan'      => $request->keterangan ?? 'Tarik Tunai Direct',
                'status'          => 'Berhasil',
                'created_at'      => now(),
                'updated_at'      => now(),
            ];

            // Filter kolom agar hanya memasukkan kolom yang ada di tabel transaksi
            $transaksiColumns = Schema::getColumnListing('transaksi');
            $insertTransaksi = array_intersect_key($dataTransaksi, array_flip($transaksiColumns));
            DB::table('transaksi')->insert($insertTransaksi);
        });

        return redirect()->back()->with('success', 'Tarik tunai berhasil dan saldo telah dipotong.');
    }

    // Menyetujui pengajuan tarik tunai dari lonceng notifikasi / dashboard
    public function setujui($id)
    {
        // 1. Cek data di tabel tarik_tunai dulu
        $data = DB::table('tarik_tunai')->where('id', $id)->first();
        $sumberTabel = 'tarik_tunai';

        // Jika tidak ketemu di tarik_tunai, cek di tabel transaksi
        if (!$data) {
            $data = DB::table('transaksi')->where('id', $id)->first();
            $sumberTabel = 'transaksi';
        }

        if (!$data) {
            return redirect()->back()->with('error', 'Data pengajuan penarikan tidak ditemukan.');
        }

        if (isset($data->status) && in_array(strtolower($data->status), ['berhasil', 'selesai', 'disetujui'])) {
            return redirect()->back()->with('error', 'Pengajuan ini sudah disetujui sebelumnya.');
        }

        $noRekening = $data->rekening ?? $data->no_rekening ?? null;
        $nominal    = $data->nominal ?? $data->jumlah ?? 0;

        if (!$noRekening) {
            return redirect()->back()->with('error', 'Nomor rekening tidak valid.');
        }

        // 2. Cek data nasabah
        $nasabah = DB::table('users')->where('no_rekening', $noRekening)->first();

        if (!$nasabah) {
            return redirect()->back()->with('error', 'Data nasabah tidak ditemukan.');
        }

        if ($nasabah->saldo < $nominal) {
            return redirect()->back()->with('error', 'Saldo nasabah tidak mencukupi.');
        }

        // 3. Update status dan potong saldo
        DB::transaction(function () use ($id, $sumberTabel, $noRekening, $nominal, $data, $nasabah) {
            // Update status di tabel pengajuan
            DB::table($sumberTabel)->where('id', $id)->update([
                'status'     => 'Berhasil',
                'updated_at' => now()
            ]);

            // Potong saldo di tabel users
            DB::table('users')
                ->where('no_rekening', $noRekening)
                ->decrement('saldo', $nominal);

            // Jika diproses dari tabel tarik_tunai, catat riwayatnya ke tabel transaksi
            if ($sumberTabel === 'tarik_tunai') {
                $dataTransaksi = [
                    'kode_transaksi'  => 'TRX-' . time() . rand(100, 999),
                    'user_id'         => $nasabah->id ?? $data->user_id ?? null,
                    'rekening'        => $noRekening,
                    'no_rekening'     => $noRekening,
                    'jenis'           => 'Tarik Tunai',
                    'jenis_transaksi' => 'Tarik Tunai',
                    'nominal'         => $nominal,
                    'keterangan'      => $data->keterangan ?? 'Persetujuan Tarik Tunai',
                    'status'          => 'Berhasil',
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ];

                $transaksiColumns = Schema::getColumnListing('transaksi');
                $insertTransaksi = array_intersect_key($dataTransaksi, array_flip($transaksiColumns));
                DB::table('transaksi')->insert($insertTransaksi);
            }
        });

        return redirect()->back()->with('success', 'Pengajuan berhasil disetujui dan saldo nasabah telah dipotong.');
    }

    // Menolak pengajuan tarik tunai
    public function tolak($id)
    {
        $data = DB::table('tarik_tunai')->where('id', $id)->first();
        $sumberTabel = 'tarik_tunai';

        if (!$data) {
            $data = DB::table('transaksi')->where('id', $id)->first();
            $sumberTabel = 'transaksi';
        }

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        DB::table($sumberTabel)->where('id', $id)->update([
            'status'     => 'Ditolak',
            'updated_at' => now()
        ]);

        return redirect()->back()->with('error', 'Pengajuan penarikan telah ditolak.');
    }
}