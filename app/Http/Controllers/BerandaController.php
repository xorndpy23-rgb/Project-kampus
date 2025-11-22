<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\ProgramZakat;
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller
{
    public function index(){
        $stats = Transaksi::select(
                // Hitung total Zakat yang sukses
                DB::raw('SUM(CASE WHEN program.jenis LIKE "%Zakat%" AND transaksis.status_pembayaran = "SUCCESS" THEN transaksis.jumlah ELSE 0 END) as total_zakat'),
                // Hitung total Infaq yang sukses
                DB::raw('SUM(CASE WHEN program.jenis NOT LIKE "%Zakat%" AND transaksis.status_pembayaran = "SUCCESS" THEN transaksis.jumlah ELSE 0 END) as total_infaq'),
                // Hitung Transaksi Pending
                DB::raw('COUNT(CASE WHEN transaksis.status_pembayaran = "PENDING" THEN 1 END) as pending_count')
            )
            ->join('program_zakats as program', 'transaksis.program_id', '=', 'program.id')
            ->first()
            ->toArray();
            
        // Hitung Program Aktif
        $stats['program_count'] = ProgramZakat::where('is_active', true)->count();
            
        // 2. Ambil Daftar Transaksi Pending/Terbaru
        $pending_transaksis = Transaksi::with('program')
                                      ->where('status_pembayaran', 'PENDING')
                                      ->orderBy('created_at', 'desc')
                                      ->paginate(10); // Menggunakan paginate 10

        return view('backend.content.beranda', [ // Pastikan nama view sesuai
            'stats' => $stats,
            'pending_transaksis' => $pending_transaksis,
        ]);
    }
    
    public function profil(){
        return view(view: 'backend.content.profil');
    }
}
