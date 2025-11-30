<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zakat;
use Midtrans\Config;
use Midtrans\Snap;

class ZakatController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = config('services.midtrans.is_sanitized', true);
        Config::$is3ds = config('services.midtrans.is_3ds', true);
    }

    public function create()
    {
        return view('zakat.create');
    }

    public function store(Request $request)
    {
        
                $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'jenis_zakat' => 'required|in:mal,fitrah,infaq',
            'nominal' => 'required|numeric|min:10000',
            'sumber_harta' => 'nullable|string',
            'jumlah_harta' => 'nullable|numeric',
            'catatan' => 'nullable|string',
        ]);


        try {
            
            $zakat = Zakat::create([
                'kode_transaksi' => 'ZAKAT-' . time() . '-' . rand(1000, 9999),
                'nama' => $request->nama,
                'email' => $request->email,
                'phone' => $request->phone,
                'jenis_zakat' => $request->jenis_zakat,
                'sumber_harta' => $request->sumber_harta,
                'jumlah_harta' => $request->jumlah_harta,
                'nominal' => $request->nominal,
                'catatan' => $request->catatan,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
            ]);

            
            return redirect()->route('zakat.show', $zakat->kode_transaksi)
                            ->with('success', 'Data zakat berhasil disimpan!');

        } catch (\Exception $e) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

   public function show($kode_transaksi)
{
    $zakat = Zakat::where('kode_transaksi', $kode_transaksi)->firstOrFail();

    if ($zakat->snap_token) {
        return view('zakat.show', compact('zakat'));
    }

    try {
       $params = [
    'transaction_details' => [
        'order_id' => $zakat->kode_transaksi,
        'gross_amount' => $zakat->nominal, 
    ],
    'customer_details' => [
        'first_name' => $zakat->nama,
        'email' => $zakat->email,
        'phone' => $zakat->phone,
    ],
    'item_details' => [
        [
            'id' => $zakat->jenis_zakat,
            'price' => $zakat->nominal,
            'quantity' => 1,
            'name' => 'Zakat ' . ucfirst($zakat->jenis_zakat),
        ]
    ],
    'enabled_payments' => [
        'gopay',
        'shopeepay',
        'qris',
        'bca_va',
        'bni_va',
        'bri_va',
        'mandiri_va',
        'permata_va',
        'alfamart',
        'indomaret'
    ]
];

        $snapToken = Snap::getSnapToken($params);
        $zakat->update(['snap_token' => $snapToken]);

        return view('zakat.show', compact('zakat'));

    } catch (\Exception $e) {
        dd('Error generate Snap token: ' . $e->getMessage());
    }
}



    private function getEnabledPayments($paymentMethod)
    {
        switch ($paymentMethod) {
            case 'bank_transfer':
                return ['bca_va', 'bni_va', 'bri_va', 'mandiri_va', 'permata_va', 'other_va'];
            case 'ewallet':
                return ['gopay', 'shopeepay', 'dana'];
            case 'qris':
                return ['qris'];
            case 'cstore':
                return ['alfamart', 'indomaret'];
            default:
                return [
                    'gopay', 
                    'shopeepay', 
                    'qris', 
                    'bca_va', 
                    'bni_va', 
                    'bri_va', 
                    'mandiri_va',
                    'alfamart',
                    'indomaret'
                ];
        }
    }

    public function success($kode_transaksi)
    {
        $zakat = Zakat::where('kode_transaksi', $kode_transaksi)->firstOrFail();
        return view('zakat.success', compact('zakat'));
    }

    public function pending($kode_transaksi)
    {
        $zakat = Zakat::where('kode_transaksi', $kode_transaksi)->firstOrFail();
        return view('zakat.pending', compact('zakat'));
    }

    public function welcome()
    {
        return view('welcome'); 
    }
}