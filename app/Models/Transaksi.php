<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'transaksi';

    // Relasi ke Rekening (Digunakan pada $transaksiTerbaru di AdminDashboardController)
    public function rekening()
    {
        return $this->belongsTo(Rekening::class);
    }

    // Relasi ke Petugas
    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }
}