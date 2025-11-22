<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramZakat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_program',
        'deskripsi',
        'jenis',
        'is_active',
    ];
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'program_id');
    }
}
