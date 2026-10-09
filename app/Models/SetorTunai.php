<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetorTunai extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'setor_tunai';

    // Kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'no_rekening',
        'jumlah_setor',
        'keterangan',
    ];
}