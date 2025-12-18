<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Zakat;
use Illuminate\Support\Facades\Hash;

class BerandaController extends Controller
{
    // ================================
    // DASHBOARD
    // ================================
    public function index()
    {
        $totalPemasukan = Zakat::sum('nominal');
        $totalPengeluaran = 0;

        $transaksiBerhasil = Zakat::where('status', 'success')->count();
        $transaksiPending  = Zakat::where('status', 'pending')->count();

        $transaksiTerbaru = Zakat::latest()->take(5)->get();

        $bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $pemasukanBulanan = [];

        foreach ($bulan as $key => $b) {
            $pemasukanBulanan[] = Zakat::whereMonth('created_at', $key + 1)
                ->sum('nominal');
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

    // ================================
    // KELOLA USER
    // ================================
    public function users()
    {
        $users = User::latest()->get();
        return view('backend.content.users', compact('users'));
    }

    // ================================
    // DATA ZAKAT (ADMIN)
    // ================================
    public function zakat()
    {
        $zakats = Zakat::latest()->get();
        return view('backend.content.zakat', compact('zakats'));
    }

    // ================================
    // DATA DONASI
    // ================================
    public function donasi()
    {
        return view('backend.content.donasi');
    }

    // ================================
    // PENGATURAN
    // ================================
    public function pengaturan()
    {
        return view('backend.content.pengaturan');
    }

    // ================================
    // PROFIL ADMIN
    // ================================
    public function profil()
    {
        $admin = auth()->user();
        return view('backend.content.profil', compact('admin'));
    }

    public function updateProfil(Request $request)
    {
        $admin = auth()->user();

        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|min:6|confirmed'
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return back()->with('pesan', 'Profil berhasil diupdate');
    }

    // ================================
    // laporan
    // ================================
public function laporan(Request $request)
{
    // Ambil filter dari request
    $jenis = $request->input('jenis');      
    $status = $request->input('status');    
    $tanggal = $request->input('tanggal');  

    // Query dasar
    $query = Zakat::query();

    if($jenis) {
        $query->where('jenis_zakat', $jenis);
    }

    if($status) {
        $query->where('status', $status);
    }

    if($tanggal) {
        $query->whereDate('created_at', $tanggal);
    }

    // Ambil data dengan pagination
    $transaksi = $query->orderBy('created_at','desc')->paginate(10)->withQueryString();

    // Summary untuk laporan
    $totalPemasukan = $transaksi->sum('nominal');
    $transaksiBerhasil = $transaksi->where('status','success')->count();
    $transaksiPending = $transaksi->where('status','pending')->count();
    $totalDonatur = $transaksi->unique('email')->count();

    return view('backend.content.laporan', compact(
        'transaksi',
        'totalPemasukan',
        'transaksiBerhasil',
        'transaksiPending',
        'totalDonatur'
    ));
}
public function berandaBackend()
{
    return redirect()->route('admin.beranda');
}

}
