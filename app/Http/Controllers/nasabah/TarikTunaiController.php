<?php
namespace App\Http\Controllers\nasabah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TarikTunaiController extends Controller
{
    /**
     * Menampilkan halaman formulir Tarik Tunai
     */
    public function index()
    {
        // Cek login
        if (!session('is_login')) {
            return redirect()->route('login');
        }

        $noRekening = session('no_rekening');

        // Ambil data user untuk mendapatkan saldo terbaru
        $user = DB::table('users')
            ->where('no_rekening', $noRekening)
            ->first();

        return view('nasabah.tariktunai', [
            'saldo' => $user->saldo ?? 0
        ]);
    }

    /**
     * Memproses pengajuan Tarik Tunai (Menunggu Konfirmasi Admin/Petugas)
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nominal'    => 'required|numeric|min:10000',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'nominal.required' => 'Jumlah penarikan wajib diisi.',
            'nominal.min'      => 'Penarikan minimal Rp 10.000.',
        ]);

        $noRekening = session('no_rekening');
        $nominal    = $request->input('nominal');
        $keterangan = $request->input('keterangan', 'Tarik Tunai');

        // Cek kecukupan saldo sebelum membuat pengajuan
        $user = DB::table('users')->where('no_rekening', $noRekening)->first();

        if (!$user || $user->saldo < $nominal) {
            return redirect()->back()->with('error', 'Saldo Anda tidak mencukupi untuk melakukan penarikan ini.');
        }

        // 1. Catat pengajuan ke tabel tarik_tunai dengan status Pending
        DB::table('tarik_tunai')->insert([
            'no_rekening' => $noRekening,
            'nominal'     => $nominal,
            'keterangan'  => $keterangan,
            'status'      => 'Pending', // Status awal pengajuan
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // Catatan: Pemotongan saldo (decrement) sengaja dihilangkan di sini.
        // Saldo baru dipotong saat Admin/Petugas menyetujui transaksi ini.

        return redirect()->back()->with(
            'success', 
            'Pengajuan tarik tunai berhasil dikirim! Silakan lakukan konfirmasi ke admin atau petugas untuk pencairan uang.'
        );
    }
}