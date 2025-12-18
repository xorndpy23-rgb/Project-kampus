<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function index()
{
    
    $totalPemasukan = Zakat::sum('nominal');

    $totalPengeluaran = 0;

    $transaksiBerhasil = Zakat::where('status', 'success')->count();
    $transaksiPending = Zakat::where('status', 'pending')->count();

    $transaksiTerbaru = Zakat::orderBy('created_at', 'desc')->take(5)->get();

    $bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

    $pemasukanBulanan = [];
    foreach ($bulan as $key => $b) {
        $pemasukanBulanan[] = Zakat::whereMonth('created_at', $key+1)->sum('nominal');
    }

    return view('backend.content.beranda', compact(
        'totalPemasukan',
        'totalPengeluaran',
        'transaksiBerhasil',
        'transaksiPending',
        'transaksiTerbaru',
        'bulan',
        'pemasukanBulanan'
    ));
}

};