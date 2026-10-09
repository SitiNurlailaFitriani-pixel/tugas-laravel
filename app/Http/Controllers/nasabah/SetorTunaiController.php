<?php
namespace App\Http\Controllers\nasabah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SetorTunai;
use Illuminate\Support\Facades\DB;

class SetorTunaiController extends Controller
{
    public function index()
    {
        return view('nasabah.setortunai');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'no_rekening'  => 'required|string',
            'jumlah_setor' => 'required|numeric|min:10000',
            'keterangan'   => 'nullable|string',
        ]);

        // 2. Simpan Data Setor Tunai
        SetorTunai::create([
            'no_rekening'  => trim($request->no_rekening),
            'jumlah_setor' => $request->jumlah_setor,
            'keterangan'   => $request->keterangan ?? 'Setor Tunai',
        ]);

        // 3. Increment Saldo di Tabel 'users'
        DB::table('users')
            ->where('no_rekening', trim($request->no_rekening))
            ->increment('saldo', $request->jumlah_setor);

        // 4. Redirect Kembali ke Dashboard
        return redirect()->route('homenasabah')->with('success', 'Setor tunai berhasil! Saldo kamu telah bertambah.');
    }
}