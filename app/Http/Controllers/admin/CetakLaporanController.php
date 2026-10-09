<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class CetakLaporanController extends Controller
{
    public function cetaklaporan(Request $request)
    {
        $query = Transaksi::with(['rekening.nasabah', 'nasabah']);

        // Jika ada filter tanggal, terapkan filter
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // Jika ada filter jenis
        if ($request->filled('jenis')) {
            $query->where('jenis_transaksi', $request->jenis);
        }

        // Jika ada filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_rekening', 'like', "%{$search}%")
                  ->orWhereHas('nasabah', function($qNasabah) use ($search) {
                      $qNasabah->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $transaksi = $query->latest()->get();

        return view('admin.cetaklaporan', compact('transaksi'));
    }
}