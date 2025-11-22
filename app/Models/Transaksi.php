<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProgramZakat;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis'; // penting: harus sama dengan migration

    protected $fillable = [
        'program_id',
        'nama',
        'email',
        'nomor_hp',
        'jumlah',
        'kode_transaksi',
        'snap_token',
        'status_pembayaran',
        'metode_pembayaran',
    ];

    public function program()
    {
        return $this->belongsTo(ProgramZakat::class, 'program_id');
    }
}
