<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarikTunai extends Model
{
    use HasFactory;

    protected $table = 'tarik_tunai';

    protected $fillable = [
        'no_rekening',
        'jumlah_tarik',
        'keterangan',
    ];
}