<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Memperbolehkan semua kolom diisi secara massal kecuali id
    protected $table = 'users'; // Mengarahkan model ke tabel 'users'
}