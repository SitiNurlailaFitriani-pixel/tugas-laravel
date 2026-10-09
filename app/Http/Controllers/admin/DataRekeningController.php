<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataRekeningController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('users as u')
            ->select(
                'u.no_rekening',
                DB::raw("COALESCE(u.username, u.name, '-') as nama_nasabah"),
                DB::raw("COALESCE(u.saldo, 0) as saldo_akhir")
            )
            ->whereNotNull('u.no_rekening');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('u.no_rekening', 'like', "%{$search}%")
                  ->orWhere('u.username', 'like', "%{$search}%")
                  ->orWhere('u.name', 'like', "%{$search}%");
            });
        }

        $rekening = $query->paginate(10)->withQueryString();

        return view('admin.datarekening', compact('rekening', 'search'));
    }

    public function destroy($no_rekening)
    {
        DB::table('users')->where('no_rekening', $no_rekening)->update([
            'no_rekening' => null,
            'saldo' => 0
        ]);

        return redirect()->route('admin.rekening.index')->with('success', 'Data rekening berhasil dihapus.');
    }
}