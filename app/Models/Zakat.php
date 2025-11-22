<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zakat extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'nama',
        'email', 
        'phone',
        'jenis_zakat',
        'sumber_harta',
        'jumlah_harta',
        'nominal',
        'catatan',
        'snap_token',
        'status'
    ];

    protected $casts = [
        'jumlah_harta' => 'decimal:2',
        'nominal' => 'decimal:2',
    ];
}