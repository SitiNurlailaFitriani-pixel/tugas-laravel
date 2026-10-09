<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'rekening';

    // Relasi ke Nasabah (Digunakan pada $transaksiTerbaru di AdminDashboardController)
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }
}