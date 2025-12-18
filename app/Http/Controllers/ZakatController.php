<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class ZakatController extends Controller
{
    // =========================
    // HALAMAN DEPAN
    // =========================
    public function welcome()
    {
        return view('welcome');
    }

    // =========================
    // FORM ZAKAT
    // =========================
    public function create()
    {
        return view('zakat.create');
    }

    // =========================
    // MIDTRANS
    // =========================
    public function midtrans(Request $request)
    {
        try {
            $request->validate([
                'nama'        => 'required',
                'email'       => 'required|email',
                'phone'       => 'required',
                'jenis_zakat' => 'required',
                'nominal'     => 'required|numeric|min:10000',
            ]);

            Config::$serverKey    = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production');
            Config::$isSanitized  = true;
            Config::$is3ds        = true;

            $orderId = 'ZKT-' . time();

            $params = [
                'transaction_details' => [
                    'order_id'     => $orderId,
                    'gross_amount' => (int) $request->nominal,
                ],
                'customer_details' => [
                    'first_name' => $request->nama,
                    'email'      => $request->email,
                    'phone'      => $request->phone,
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'snap_token' => $snapToken,
                'order_id'   => $orderId
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Midtrans error',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // =========================
    // REDIRECT STATUS
    // =========================
    public function success($kode)
    {
        return view('zakat.success', compact('kode'));
    }

    public function pending($kode)
    {
        return view('zakat.pending', compact('kode'));
    }
}
